/*
* Arquivo de configuração do banco de dados
*
* author: Gustavo Grimaldi Campello
* since: 16/08/2017
*/
module.exports = {  
    port: process.env.PORT || 8123,
  db: {
    host: process.env.DATABASE_HOST || '127.0.0.1',
    database: 'users',
    user: 'users_service',
    password: '123',
    port: 3306
  }
};
