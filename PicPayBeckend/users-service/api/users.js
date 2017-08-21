/*
* Define a API users. Para adicionar ao servidor basta adicionar:
* require('./users')
*
* author: Gustavo Grimaldi Campello
* since: 16/08/2017
*/
'use strict';
var fs = require('fs');
var path = require('path');

/* 
* Deixa em memoria a lista para consulta das prioridades. So foi adicionado isso porque o arquivo 
* era pequeno e não sabia se poderia criar uma tabela adicional no banco contendo o id e a prioridade 
*(facilitaria muito colocar pela consulta)
*/
var priority_1 = new Array();
var priority_2 = new Array();

priority_1 = loadFile('../extradata/lista_relevancia_1.txt');
priority_2 = loadFile('../extradata/lista_relevancia_2.txt');

/*
* Funcao para carregar arquivos
*/
function loadFile(filePath) {
    var data = fs.readFileSync(path.join(__dirname, filePath), 'utf8');
    return data.toString().split("\n");
}

/*
* Ordena o vetor com base no id e as listas de prioridade;
*/
function compare(users) {
    var array1 = [];
    var array2 = [];
    var array3 = [];
    for (var element in users) {
        if (priority_1.indexOf(users[element].id) > -1) {
            array1.push(users[element]);
        } else if (priority_2.indexOf(users[element].id) > -1) {
            array2.push(users[element]);
        } else {
            array3.push(users[element]);
        }
    }
    return array1.concat(array2).concat(array3);
}

/*
* Exporta o modulo- adiciona a API ao app.
*/
module.exports = (app, options) => {

    app.get('/users', (req, res, next) => {
        var key = req.query.key;
        if (!key) {
            key = '';
        }
        var page = req.query.page;
        if (!page) {
            page = 0;
        }
        options.repository.getUsers(key, page).then((users) => {
            users = compare(users);
            res.status(200).send(users.map((user) => {
                return {
                    id: user.id,
                    name: user.name,
                    username: user.username
                };
            }));
        })
            .catch(next);
    });
};