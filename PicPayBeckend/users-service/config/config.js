//  config.js
//
//  Arquivo de configuracao
module.exports = {  
    port: process.env.PORT || 8123,
  db: {
    host: process.env.DATABASE_HOST || '127.0.0.1',
    database: 'picpaybackendtest',
    user: 'root',
    password: 'root',
    port: 3306
  }
};

/*
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
*/