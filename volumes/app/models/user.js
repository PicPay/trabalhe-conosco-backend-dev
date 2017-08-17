var mongoose = require('mongoose');
var userSchema = new mongoose.Schema({
  id: { type: String, unique: true, index:true },
  name: String,
  username: String,
  tags: { type: [String], index:true },
  lista1: { type: Number, default: 0 },
  lista2: { type: Number, default: 0 },
});

userSchema.statics.setTags  = function (callback){
  var userFunctions = require('../userFunctions');
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

userSchema.statics.setPriorityLists  = function (callback){
  var userFunctions = require('../userFunctions');
  var lista_relevancia_1 = './static/files/lista_relevancia_1.txt';
  var lista_relevancia_2 = './static/files/lista_relevancia_2.txt';
  var arrayIdsAll = [];
  var arrayIds1 = [];
  var arrayIds2 = [];

  var async = require('async');
  async.parallel([ //leitura dos arquivos lista
    function(cb) {
      userFunctions.getPriorityLists(lista_relevancia_1,function(err,arrayIds){ //le a primeira lista_relevancia
        if (err) return cb(err);
        arrayIds1=arrayIds;
        return cb();
      });
    },
    function(cb) {
      userFunctions.getPriorityLists(lista_relevancia_2,function(err,arrayIds){ //le a segunda lista_relevancia
        if (err) return cb(err);
        arrayIds2=arrayIds;
        return cb();
      });
    }
  ], function(err) { //terminou a leitura
    if (err) return next(err);
    arrayIdsAll = arrayIds1.concat(arrayIds2);
    console.log(arrayIdsAll);
  });
};



var User = mongoose.model('User', userSchema);
module.exports = User;
