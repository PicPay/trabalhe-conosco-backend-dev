/*
* Classe responsável por fazer requisição diretamente ao banco.
*
* author: Gustavo Grimaldi Campello
* since: 16/08/2017
*/

'use strict';

var mysql = require('mysql');

class Repository {  
  constructor(connection) {
    this.connection = connection;
  }

  getUsers(key,page) {
    return new Promise((resolve, reject) => {

      this.connection.query('SELECT id, name, username , (Case when priority.priority = 2 then 2 when  priority.priority =1 then 1 else 3 end) as p  FROM users LEFT JOIN priority on users.id=priority.id_user WHERE name LIKE "'+ key +'%" or username LIKE "'+ key +'%" ORDER BY p LIMIT ' + page*15+',15;', (err, results) => {
        if(err) {
          return reject(new Error("Ocorreu um erro ao retornar usuarios: " + err));
        }

        resolve((results || []).map((user) => {
          return {
            id: user.id,
            name: user.name,
            username: user.username
          };
        }));
      });

    });
  }

  disconnect() {
    this.connection.end();
  }
}

/*
* Verifica os parametros passados para conecao
*/
module.exports.connect = (connectionSettings) => {  
  return new Promise((resolve, reject) => {
    if(!connectionSettings.host) throw new Error("A host must be specified.");
    if(!connectionSettings.user) throw new Error("A user must be specified.");
    if(!connectionSettings.password) throw new Error("A password must be specified.");
    if(!connectionSettings.port) throw new Error("A port must be specified.");

    resolve(new Repository(mysql.createConnection(connectionSettings)));
  });
};