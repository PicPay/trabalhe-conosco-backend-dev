"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express = require("express");
const consign = require("consign");
const bodyParser = require("body-parser");
var cors = require('cors');
require("reflect-metadata");
let app = express();
let expressValidator = require('express-validator');
app.use(cors());
app.use(expressValidator());
app.use(bodyParser.json({ limit: '50mb', type: 'application/json' }));
app.use(bodyParser.urlencoded({ extended: false }));
consign({ cwd: 'server' })
    .then('routes/add.js')
    .then('routes/auth.js')
    .then('routes')
    .into(app);
module.exports = app;
