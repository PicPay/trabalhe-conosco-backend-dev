var express = require('express');
var app = express();
var db = require('./db');
var passport = require('passport');
var LocalStrategy = require('passport-local').Strategy;
var bodyParser = require('body-parser');
var cookieParser = require('cookie-parser');

//logger
var logger = require('morgan');
app.use(logger('dev'));

//passport (auth)
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(require('express-session')({
    secret: 'keyboard cat',
    resave: false,
    saveUninitialized: false
}));
app.use(passport.initialize());
app.use(passport.session());

var Account = require('./models/account');
passport.use(new LocalStrategy(Account.authenticate()));
passport.serializeUser(Account.serializeUser());
passport.deserializeUser(Account.deserializeUser());

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

var accountController = require('./controllers/accountController');
app.use('/account', accountController);

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
      res.render('index', { user : req.user });
    }
  });
});

module.exports = app;
