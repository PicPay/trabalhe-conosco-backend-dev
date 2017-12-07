var express = require('express'),
    app = express(),
    port = process.env.PORT || 3003,
    mongoose = require('mongoose'),
    User = require('./api/models/userModel'),
    bodyParser = require('body-parser'),
    cors = require('cors');

// Instance mongoose
mongoose.Promise = global.Promise;
mongoose.connect('mongodb://localhost/picpay')

// Config body-parser
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Config CORS
var corsOptions = {
    origin: 'http://localhost:4200',
    credentials: true
}
app.use(cors(corsOptions));

// Config routes
var routes = require('./api/routes/serverRoutes');
routes(app, cors);

app.listen(port);

console.log('API Picpay PS is started on port ' + port);