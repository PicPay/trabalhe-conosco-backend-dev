import { Meteor } from 'meteor/meteor';
import { CSV } from 'meteor/clinical:csv';
import { join } from 'path';
import { Users } from '../import/api/users.js';
import { open } from 'fs'
import { read } from 'fs'

// path: Path of the file relative to the private folder
function loadCSVtoDB(path) {
  path = join(process.env.PWD, 'private', path);

  createUser = (line) => {
    return { _id: line[0], Nome: line[1], Username: line[2], Relevancia: 3 };
  }

  let insertions = [];
  insertToDB = (line) => {
    insertions.push(new Promise((resolve, reject) => {
      onInsertion = (error, result) => {
        if (error) { reject(line, error); }
        resolve();
      }
      Users.insert(createUser(line), onInsertion);
    }));
  };

  CSV.readCsvFileLineByLine(path, {}, Meteor.bindEnvironment(insertToDB));
  return Promise.all(insertions)
}

// path: Path of the file relative to the private folder
function checkRelevance(path, relevance) {
  path = join(process.env.PWD, 'private', path);
  let buffer = []
  open(path, 'r', (err, fd) => {
    if (err) {
      if (err.code === 'ENOENT') {
        console.error('myfile does not exist');
        return;
      }
      throw err;
    }
    read(fd, buffer, 0, 15, 0, (err, buffer, bytesRead) => {
      buffer.forEach((value) => {
        if (Users.findOne(value)) { Users.update(value, { $set: { Relevancia: relevance } }) }
      })
    });
  });
}
Meteor.startup(() => {
  if (Users.find().count() === 0) {
    loadCSVtoDB('db/bubu.csv')
      .catch((line, error) => {
        console.log('Linha com erro: ' + line)
        console.log(error)
      })
      .then(() => {
        console.log(Users.find().count())
        checkRelevance('db/lista_relevancia_1', 1)
        checkRelevance('db/lista_relevancia_2', 2)
      }
      )
  }
});
