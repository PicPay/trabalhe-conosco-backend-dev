//Requisitos
var express = require("express");
var bodyParser = require("body-parser");
var consign = require("consign");
const mysql = require('mysql');
var jwt = require("jwt-simple");
var cfg = require("./config.js");
var auth = require("./auth.js")();

const app = express();

//Conexao com banco de dados
const con = mysql.createConnection({
  host: cfg.db.host,
  user: cfg.db.user,
  password: cfg.db.password,
  database: cfg.db.database,
  port: cfg.db.port
});

con.connect((err) => {
  if(err){
    console.log('Erro ao conectar no DB');
    return;
  }
  console.log('Conexão estabelecida');
});

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(auth.initialize());

//Rota para gerar token de autenticação do usuario da API, sendo passados user e senha via POST no body
app.post("/token", function(req, res) {
  if (req.body.login && req.body.password) {

    var login = req.body.login;
    var password = req.body.password;

    con.query('select * from autenticacao where login = ? and password = ? ', [login, password] , (err,rows) => {
      if(err){
        throw err;
      }

      if(rows.length == 0)
        var user = null;
      else
        var user = rows[0];

      if (user) {
        var payload = {id: user.id};
        var token = jwt.encode(payload, cfg.jwtSecret);

        res.status(200);
        res.setHeader('Content-Type', 'application/json');
        res.json({token: token});

      } else {
        res.sendStatus(401);
      }

    });

  } else {
    res.sendStatus(401);
  }
});

consign()
  .include("libs/middlewares.js")
  .then("routes")
  .then("libs/boot.js")
  .into(app, con);
