var mongoose = require('mongoose');
var async = require('async');
var userSchema = new mongoose.Schema({
  id: { type: String, unique: true, index:true },
  name: String,
  username: String,
  tags: { type: [String], index:true },
});

userSchema.statics.updateAll  = function (callback){
  console.log("aqui");
  this.find({}).stream()
     .on('data', function(user){
        createTagsField(user.name,user.username,function(err,tags){
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

function createTagsField(name,username,callback){ //cria o campo tags para otimizar a busca
  async.parallel([ //padronizando as strings de username e user em paralelo
    function(cb) {
      standardizeString(name,function(err,stdName){ //padroniza name
        if (err) return cb(err);
        name=stdName;
        return cb();
      });
    },
    function(cb) {
      standardizeString(username,function(err,stdUsername){ //padroniza username
        if (err) return cb(err);
        username=stdUsername;
        return cb();
      });
    }
  ], function(err) { //terminou de padronizar as duas, insere o field tags no elemento
    if (err) return next(err);
    removeDuplicatesFromArrays(name,username,function (err,tags) { //remove elementos repetidos
      return callback(null,tags);
    });
  });
};

function removeDuplicatesFromArrays(array1,array2,callback){
  var a = new Set(array1);
  var b = new Set(array2);
  var onlyArray1Has = (new Set([...a].filter(x => !b.has(x)))); //a\b
  var onlyArray2Has = (new Set([...b].filter(x => !a.has(x)))); //b\a
  var bothArraysHas = (new Set([...a].filter(x => b.has(x))));  //a∩b
  var arrStd = new Set([...onlyArray1Has, ...onlyArray2Has, ...bothArraysHas])
  arrStd = [...arrStd]; //convertendo set em array
  return callback(null,arrStd);
};

function standardizeString (str,callback){
  str = str.toLowerCase(); //coloca em minusculo
  str = str.split(/[ .]+/); //remove pontos e espacos
  var temp = [];
  for(let i of str)
      i && temp.push(i); // copia os valores nao vazios para um array temporario
  str = temp;
  delete temp; // discard the variable
  return callback(null,str);
};

var User = mongoose.model('User', userSchema);
module.exports = User;
