
module.exports = {
  createTagsField: function(name,username,callback){
    var async = require('async');
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
  },
}

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
