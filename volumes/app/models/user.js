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
  var async = require('async');
  var lista_relevancia_1 = './static/files/lista_relevancia_1.txt';
  var lista_relevancia_2 = './static/files/lista_relevancia_2.txt';
  var arrayIdsAll = [];
  var arrayIds1 = [];
  var arrayIds2 = [];
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
  ], function(err) { //terminou a leitura dos arquivos, hora de inserir no banco
    if (err) return next(err);
    var count2 = 0;
    var count1 = 0;
    async.parallel([ //setar variaveis no banco
      function(cb) {
        for (var i = 0, len1 = arrayIds1.length; i < len1; i++){ //for mais eficiente, nao le o tamanho do vetor a cada iteracao
          User.update({id: arrayIds1[i]}, { lista1: 1 }, function(err) {
              if (err) return cb(err);
              count1++;
              if(count1 == len1) return cb();//terminou de atualizar todas as entradas para lista1
            });
        }
      },
      function(cb) {
        for (var j = 0, len2 = arrayIds2.length; j < len2; j++){ //for mais eficiente, nao le o tamanho do vetor a cada iteracao
          User.update({id: arrayIds2[j]}, { lista2: 1 }, function(err) {
              if (err) return cb(err);
              count2++;
              if(count2 == len2) return cb();//terminou de atualizar todas as entradas para lista1
            });
        }
      }
    ], function(err) { //terminou a leitura dos arquivos
      if (err) return next(err);
      return callback();
    });
  });
};

var User = mongoose.model('User', userSchema);
module.exports = User;
