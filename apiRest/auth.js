// auth.js
//Configuracao do jwt e passport para autenticacao das rotas via token
var passport = require("passport");
var passportJWT = require("passport-jwt");
const mysql = require('mysql');

var cfg = require("./config.js");
var ExtractJwt = passportJWT.ExtractJwt;
var Strategy = passportJWT.Strategy;
var params = {
  secretOrKey: cfg.jwtSecret,
  jwtFromRequest: ExtractJwt.fromHeader("token")
};

//Conexao com banco de dados
const con = mysql.createConnection({
  host: cfg.db.host,
  user: cfg.db.user,
  password: cfg.db.password,
  database: cfg.db.database,
  port: cfg.db.port
});

module.exports = function() {
  var strategy = new Strategy(params, function(payload, done) {
    
    con.query('select * from autenticacao where id= ? ', payload.id, (err,rows) => {
      if(err){
        throw err;
      }

      if(rows.length == 0)
        var user = null;
      else
        var user = rows[0];

      if (user) {
        return done(null, {id: user.id});
      } else {
        return done(new Error("User not found"), null);
      }
      
    });
  });
  
  passport.use(strategy);
  return {
    initialize: function() {
      return passport.initialize();
    },
    authenticate: function() {
      return passport.authenticate("jwt", cfg.jwtSession);
    }
  };
};