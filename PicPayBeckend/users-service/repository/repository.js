//  repository.js
//
// 
//Exporta uma unica funcao - 'conectar', que retorna
//um repositorio conectado. Ligue para 'desconectar' nesse objeto quando terminar.
'use strict';

var mysql = require('mysql');


// Classe que contem uma conexão aberta a um repositorio
// e expoe algumas funções simples para acessar dados.
class Repository {  
  constructor(connection) {
    this.connection = connection;
  }

  getUsers(key,page) {
    return new Promise((resolve, reject) => {

      this.connection.query('SELECT id, name, username FROM users WHERE name LIKE "%'+ key +'%" or username LIKE "%'+ key +'%" ORDER BY name LIMIT ' + page*15+',15;', (err, results) => {
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

  getUserByEmail(email) {

    return new Promise((resolve, reject) => {

      //  Fetch the customer.
      this.connection.query('SELECT email, phone_number FROM directory WHERE email = ?', [email], (err, results) => {

        if(err) {
          return reject(new Error("Ocorreu um erro ao retornar usuario: " + err));
        }

        if(results.length === 0) {
          resolve(undefined);
        } else {
          resolve({
            email: results[0].email,
            phone_number: results[0].phone_number
          });
        }

      });

    });
  }

  disconnect() {
    this.connection.end();
  }
}

//  Uma e única função exportada, retorna um repo conectado.
module.exports.connect = (connectionSettings) => {  
  return new Promise((resolve, reject) => {
    if(!connectionSettings.host) throw new Error("A host must be specified.");
    if(!connectionSettings.user) throw new Error("A user must be specified.");
    if(!connectionSettings.password) throw new Error("A password must be specified.");
    if(!connectionSettings.port) throw new Error("A port must be specified.");

    resolve(new Repository(mysql.createConnection(connectionSettings)));
  });
};