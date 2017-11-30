import { Meteor } from 'meteor/meteor';
import { CSV } from 'meteor/clinical:csv';
import { join } from 'path';
import { Users } from '../import/api/users.js';
import { open } from 'fs'
import { read } from 'fs'

// Fiber = require('fibers');

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
  function readAll(fd, relevance) {
    var lineReader = require('readline').createInterface({
      input: require('fs').createReadStream('', { fd: fd })
    });

    lineReader.on('line', Meteor.bindEnvironment(function (line) {
      Users.update(line, { $set: { Relevancia: relevance } })
    }));
  }

  path = join(process.env.PWD, 'private', path);
  open(path, 'r', Meteor.bindEnvironment((err, fd) => {
    if (err) {
      if (err.code === 'ENOENT') {
        console.error('myfile does not exist');
        return;
      }
      throw err;
    }
    readAll(fd, relevance)
  }));
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
        checkRelevance('db/lista_relevancia_1.txt', 1)
        checkRelevance('db/lista_relevancia_2.txt', 2)
      }
      )
  }
});
