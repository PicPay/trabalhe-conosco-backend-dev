var promise = require('bluebird');

var options = {
  // Initialization Options
  promiseLib: promise
};

var pgp = require('pg-promise')(options);
var connectionString = 'postgres://docker:docker@db:5432/docker'; 
var db = pgp(connectionString);

function getRegisters(req, res, next) {
  var page =  Math.max((15*(parseInt(req.query.offset)-1)),0);
  var query=decodeURI(req.query.name);
  console.log(query);
  db.any('SELECT users.* FROM picpay.registers users ' +
              'LEFT JOIN picpay.rank1 ON rank1.id = users.id ' +
              'LEFT JOIN picpay.rank2 ON rank2.id = users.id ' +
              'WHERE lower(users.name) LIKE lower(\'${name:value}%\') ' +
              'OR users.username LIKE \'${name:value}%\' '+
              'ORDER BY rank1.id is null, rank2.id is null, users.id ' +
              'LIMIT 15 OFFSET ${offset:value}', {
      name: query,
      offset: page
    })
    .then(function (data) {
      res.status(200)
        .json({
          status: 'success',
          data: data,
          message: 'Retrieved all starships'
        });
    })
    .catch(function (err) {
      return next(err);
    });
}


module.exports = {
    getRegisters: getRegisters,
};
