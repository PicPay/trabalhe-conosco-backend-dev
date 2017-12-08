import { Meteor } from 'meteor/meteor';
import { CSV } from 'meteor/clinical:csv';
import { join } from 'path';
import { UsersDB, userDBContext } from '../imports/api/usersDB.js';
import { open, read } from 'fs';
import { bigram } from 'n-gram';
async = require("async")
// nGram = require('n-gram');


// path: Path of the list of relevance relative to the private folder
// relevance: Relevance desired to the user when on the list
checkRelevance = (path, relevance) => {

  readAll = (fd, relevance) => {
    let batch = UsersDB.rawCollection().initializeUnorderedBulkOp()
    let nLines = 0

    let lineReader = require('readline').createInterface({
      input: require('fs').createReadStream('', { fd: fd })
    });

    let onRelevanceCheck = (error) => {
      if (error) throw error
    }

    let updateRelevance = (line) => {
      if (line) {
        batch.find({ _id: line }).updateOne({ $set: { Relevancia: relevance } });
        nLines++;
        if (nLines >= 1000) {
          batch.execute(onBulkExecute);
          batch = UsersDB.rawCollection().initializeUnorderedBulkOp();
          nLines = 0
        }
      }
    }

    onBulkExecute = (error, result) => {
      if (error) throw (error);
      // maybe do something with result
    }

    lineReader.on('line', Meteor.bindEnvironment((line) => {
      async.series([(onRelevanceCheck) => {
        updateRelevance(line);
      }], (error) => { throw error });
    }));

    lineReader.on('close', Meteor.bindEnvironment(() => {
      if (nLines) { batch.execute(onBulkExecute) }
    }))
  }

  path = join(process.env.PWD, 'private', path);
  open(path, 'r', Meteor.bindEnvironment((err, fd) => {
    if (err) {
      if (err.code === 'ENOENT') {
        console.error('File does not exist');
        return;
      }
      throw err;
    }
    readAll(fd, relevance);
  }));
}

// path: Path of the file relative to the private folder
loadCSVtoDB = (path) => {

  readAll = (fd, relevance) => {
    let nLines = 0
    let lineParsed = ''
    let batch = UsersDB.rawCollection().initializeUnorderedBulkOp()

    let lineReader = require('readline').createInterface({
      input: require('fs').createReadStream('', { fd: fd })
    });

    onBulkExecute = (error, result) => {
      if (error) throw (error);
      // maybe do something with result
    }

    onCSVtoDB = (error) => {
      if (error) throw error;
    }

    make_ngrams = (text) => {
      
    }

    uploadUsers = (line) => {
      if (line) {
        let user = { _id: '', Nome: '', Username: '', Hash: '', Relevancia: 3 };
        lineParsed = CSV.parse(line);
        user._id = lineParsed.data[0][0];
        user.Nome = lineParsed.data[0][1];
        user.Username = lineParsed.data[0][2];
        user.Hash = bigram(lineParsed.data[0][1]);
        if (userDBContext.validate(user)) {
          batch.insert(user)
          nLines++;
        } else { onCSVtoDB("Invalid line: " + line) }
        if (nLines >= 1000) {
          batch.execute(onBulkExecute)
          batch = UsersDB.rawCollection().initializeUnorderedBulkOp()
          nLines = 0
        }
      }
    }

    lineReader.on('line', Meteor.bindEnvironment((line) => {
      async.series(
        [
          (onCSVtoDB) => {
            uploadUsers(line)
          }
        ],
        (error) => { throw error }
      )
    }));

    lineReader.on('close', Meteor.bindEnvironment(() => {
      if (nLines) {
        batch.execute(onBulkExecute)
      }
      checkRelevance('db/lista_relevancia_1.txt', 1)
      checkRelevance('db/lista_relevancia_2.txt', 2)
    }))
  }

  path = join(process.env.PWD, 'private', path);
  open(path, 'r', Meteor.bindEnvironment((err, fd) => {
    if (err) {
      if (err.code === 'ENOENT') {
        console.error('File does not exist');
        return;
      }
      throw err;
    }
    readAll(fd)
  }));
}

Meteor.startup(() => {
  // UsersDB._ensureIndex(
  //   { 
  //     Name: "text",
  //     Username: "text"
  //   }
  // );
  if (UsersDB.find().count() === 0) {
    loadCSVtoDB('db/32.csv')
  }
  // UsersDB.find({}, {
  //   fields: {
  //     Nome: 1,
  //     Username: 1
  //   }
  // }).forEach((doc) => {
  //   console.log(doc);
  // })
});
