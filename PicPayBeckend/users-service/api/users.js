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