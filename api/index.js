const express = require('express');

const bodyParser = require('body-parser');
const routes = require('./routes/routes');

const app = express();

app.use(bodyParser.urlencoded({ 
	extended: true 
}));
app.use(bodyParser.json());
app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});

//routes

app.use('/', routes);

console.log("You are in!!");
app.listen(3000);

module.exports = app;