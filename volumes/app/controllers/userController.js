var express = require('express');
var router = express.Router();
var bodyParser = require('body-parser');
router.use(bodyParser.urlencoded({ extended: true }));
var User = require('../models/user');

module.exports = router;

router.post('/', function (req, res) {
  User.create({
    id_sec:   req.body.id_sec,
    name : req.body.name,
    username : req.body.username,
    lista1 : req.body.lista1,
    lista2 : req.body.lista2,
  },
  function (err, user) {
    if (err) return res.status(500).send("There was a problem adding the information to the database.");
    res.status(200).send(user);
  });
});

router.get('/:page/:query', function (req, res) {
  var page = Number(req.params.page);
  var query = req.params.query;
  query = {tags: query};
  var options = {
      select:   'id_sec name username lista1 lista2',
      sort:     { lista1: -1,  lista2: -1},
      lean:     true, //Documents returned from queries with the lean option enabled are plain javascript... This is a great option in high-performance read-only scenarios
      page:   page,
      limit:    15
  };
  User.paginate(query, options).then(function(result) {
      res.send(result);
  });
});

router.get('/:id', function (req, res) {
  User.findById(req.params.id, function (err, user) {
    if (err) return res.status(500).send("There was a problem finding the user.");
    if (!user) return res.status(404).send("No user found.");
    res.status(200).send(user);
  });
});

router.delete('/:id', function (req, res) {
  User.findByIdAndRemove(req.params.id, function (err, user) {
    if (err) return res.status(500).send("There was a problem deleting the user.");
    res.status(200).send("User "+ user.name +" was deleted.");
  });
});

router.put('/:id', function (req, res) {
  User.findByIdAndUpdate(req.params.id, req.body, {new:true}, function (err, user) {
    if (err) return res.status(500).send("There was a problem updating the user.");
    res.status(200).send(user);
  });
});
