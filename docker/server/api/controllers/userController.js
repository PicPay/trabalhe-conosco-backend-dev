var mongoose = require('mongoose'),
    User = mongoose.model('Users'),
    fs = require('fs');

/**
 * Função para ler os dados de um arquivo.
 * 
 * @param {*} file path do arquivo
 * @param {*} callback callback para executar o método e responder com os dados do arquivo
 * @author L.Gomes
 */
function read(file, callback) {
    fs.readFile(file, 'utf8', function (err, data) {
        if (err) {
            console.log(err);
        }
        callback(data);
    });
}

var preferentialLists = [];
read('lista_relevancia_1.txt', function (data) {
    preferentialLists.push(data.split(/\r?\n/));
    read('lista_relevancia_2.txt', function (data) {
        preferentialLists.push(data.split(/\r?\n/));
    });
});

/**
 * Serviço de listar usuários sem o uso dos filtros.
 * 
 * @param {*} req objeto da requisição do cliente
 * @param {*} res resposta do servidor
 * @param {*} next objeto referência da próxima função a ser executada
 * @author L.Gomes
 */
exports.list_users = function (req, res, next) {
    var skip = Number(req.params.skip);
    var limit = Number(req.params.limit);
    User
        .find({})
        .skip(skip)
        .limit(limit)
        .exec(function (err, users) {
            User
                .count()
                .skip(skip + 15)
                .limit(limit)
                .exec(function (err, count) {
                    if (err) return next(err)
                    users.sort(function (a, b) {
                        var idA = a.id;
                        var idB = b.id;
                        if (preferentialLists[0].indexOf(idA) !== -1)
                            return 1;
                        if (preferentialLists[0].indexOf(idB) !== -1)
                            return -1;
                        if (preferentialLists[1].indexOf(idA) !== -1)
                            return 1;
                        if (preferentialLists[1].indexOf(idB) !== -1)
                            return -1;
                        else
                            return 0;
                    });
                    res.send({
                        users: users,
                        hasNextPage: count !== 0
                    });
                });
        });
}

/**
 * Serviço de listar usuários com o uso dos filtros.
 * 
 * @param {*} req objeto da requisição do cliente
 * @param {*} res resposta do servidor
 * @param {*} next objeto referência da próxima função a ser executada
 * @author L.Gomes
 */
exports.list_users_filtered = function (req, res) {
    var skip = Number(req.params.skip);
    var limit = Number(req.params.limit);
    var regex = new RegExp(req.params.filter);
    User
        .find({ $or: [{ 'name': { $regex: regex, $options: 'i' } }, { 'username': { $regex: regex, $options: 'i' } }] })
        .skip(skip)
        .limit(limit)
        .exec(function (err, users) {
            User
                .count({ $or: [{ 'name': { $regex: regex, $options: 'i' } }, { 'username': { $regex: regex, $options: 'i' } }] })
                .skip(skip + 15)
                .limit(limit)
                .exec(function (err, count) {
                    if (err) return next(err)
                    users.sort(function (a, b) {
                        var idA = a.id;
                        var idB = b.id;
                        if (preferentialLists[0].indexOf(idA) !== -1)
                            return 1;
                        if (preferentialLists[0].indexOf(idB) !== -1)
                            return -1;
                        if (preferentialLists[1].indexOf(idA) !== -1)
                            return 1;
                        if (preferentialLists[1].indexOf(idB) !== -1)
                            return -1;
                        else
                            return 0;
                    });
                    res.send({
                        users: users,
                        hasNextPage: count !== 0
                    });
                });
        });
}

