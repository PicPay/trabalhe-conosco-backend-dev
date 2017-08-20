var express = require('express');
var app = express();
var db = require('./db');

//logger
var logger = require('morgan');
app.use(logger('dev'));

//setando favicon
var favicon = require('serve-favicon');
app.use(favicon(__dirname + '/static/images/picpayicon.png'));

//adicionando time-stamp nas mensagens de log
require('console-stamp')(console, '[HH:MM:ss.l]');

//setando diretorios estaticos
app.use('/img',express.static(__dirname + '/static/images'));
app.use('/js', express.static(__dirname + '/node_modules/bootstrap/dist/js')); // redirect bootstrap JS
app.use('/js', express.static(__dirname + '/node_modules/jquery/dist')); // redirect JS jQuery
app.use('/js', express.static(__dirname + '/static/js')); // redirect JS jQuery
app.use('/css', express.static(__dirname + '/node_modules/bootstrap/dist/css')); // redirect bootstrap JS
app.use('/css',express.static(__dirname + '/static/css'));
app.use('/css', express.static(__dirname + '/node_modules/font-awesome/css'))
app.use('/fonts', express.static(__dirname + '/node_modules/bootstrap/fonts')); // redirect bootstrap fonts
app.use('/fonts', express.static(__dirname + '/node_modules/font-awesome/fonts')); // redirect bootstrap fonts
app.use('/images',express.static(__dirname + '/static/images'));

// set the view engine to ejs
app.set('views', __dirname + '/views');
app.set('view engine', 'ejs');

//controllers
var UserController = require('./controllers/userController');
app.use('/users', UserController);

var dbFunctions = require('./dbFunctions');
dbFunctions.checkDB(function(err){
  console.log("Banco de dados pronto.");
});

app.get('/', function (req, res) {
  var pathExists = require('path-exists');
  pathExists('index_tags.lock').then(exists => {
    if(exists) {
      res.render('loadingDataBase');
    }else{
      res.render('index');
    }
  });
});
app.get('/login', function (req, res) {
  res.render('login');
});

module.exports = app;
