var express = require('express');
var router = express.Router();
var bodyParser = require('body-parser');
router.use(bodyParser.urlencoded({ extended: true }));
var User = require('../models/user');

module.exports = router;

router.post('/', function (req, res) {
  User.create({
    id:   req.body.id,
    name : req.body.name,
    username : req.body.username,
  },
  function (err, user) {
    if (err) return res.status(500).send("There was a problem adding the information to the database.");
    res.status(200).send(user);
  });
});

router.get('/', function (req, res) {
  User.find({}, function (err, users) {
    if (err) return res.status(500).send("There was a problem finding the users.");
    res.send(users);
  });
});

// router.get('/update', function (req, res) {
//   User.updateAll(function(callback){
//     console.log("atualizados");
//   });
// });

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


router.get('/teste/:id', function (req, res) {
  User.findById(req.params.id, function (err, user) {
    user.createTagsField(req.params.id, function (err){
      if (err) return res.status(500).send("There was a problem deleting the user.");
      res.status(200).send("User "+ user.name +" was deleted.");
    });
  });
});
