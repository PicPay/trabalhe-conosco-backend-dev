var mongoose = require('mongoose');
var userSchema = new mongoose.Schema({
  id: {type: String, unique: true},
  name: String,
  username: String,
});

var User = mongoose.model('User', userSchema);
module.exports = User;
