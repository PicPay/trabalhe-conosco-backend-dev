var mongoose = require('mongoose');
var userSchema = new mongoose.Schema({
  id: { type: String, unique: true, index:true },
  name: String,
  username: String,
  tags: { type: [String], index:true },
  lista1: { type: Number, default: 0 },
  lista2: { type: Number, default: 0 },
});

userSchema.statics.updateAll  = function (callback){
  var functions = require('../userFunctions');
  this.find({}).stream()
     .on('data', function(user){
        userFunctions.createTagsField(user.name,user.username,function(err,tags){
          user.set('tags', tags);
          user.save(function (error) {
            if (error) throw error;
          });
        });
  })
  .on('error', function(error) {
      throw error;
  })
  .on('end', function() {
      // final callback
      console.log("TERMINEI DE ATUALIZAR");
      return callback();
  });
};

var User = mongoose.model('User', userSchema);
module.exports = User;
