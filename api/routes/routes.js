const express = require('express');
const Controller = require('../controllers/Controller')
const router = express.Router();


//Routes
router.get('/search', (req, res) => {});

router.post('/login', Controller.Login);

router.post('/register', Controller.Register);

router.post('/search/:page', Controller.getUsers);

module.exports = router;