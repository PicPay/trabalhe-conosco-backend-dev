
//server.js

var express = require('express');  
var morgan = require('morgan');
var path = require('path');


module.exports.start = (options) => {

  return new Promise((resolve, reject) => {

    //  Ter certeza que que tem foi provido um repository e uma porta.
    if(!options.repository) throw new Error("A server must be started with a connected repository.");
    if(!options.port) throw new Error("A server must be started with a port.");

    // Cria o app, adciona algum registro.
    var app = express();
    app.use(morgan('dev'));

    //  Adiciona APIs ao app.
    require('../api/users')(app, options);


    app.get('/', function(request, response){
      response.sendFile(path.join(__dirname,'../front/index.html'));
    });
    app.use('/',express.static(path.join(__dirname,'../front')));

    //  Inicia o app, criando um servidor que retornamos.
    var server = app.listen(options.port, () => {
      resolve(server);
    });

  });
};