import { Meteor } from 'meteor/meteor';
import { CSV } from 'meteor/clinical:csv';
import { join } from 'path';
import { Users } from '../import/api/users.js';

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


Meteor.startup(() => {
  if (Users.find().count() === 0) {
    loadCSVtoDB('db/bubu.csv')
      .catch((line, error) => {
        console.log('Linha com erro: ' + line)
        console.log(error)
      })
      .then(() =>
        console.log(Users.find().count())
        checkRe
      )
  }
});
