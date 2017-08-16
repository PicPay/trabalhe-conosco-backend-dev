"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const userservicesingleton_1 = require("./../factories/user/userservicesingleton");
let userService = userservicesingleton_1.UserServiceSingleton.Instance;
module.exports = (app) => {
    app.route('/user').post((req, res, next) => {
        let page = 1;
        if (req.body.page)
            page = req.body.page;
        userService.findByNome(req.body.palavra, page).then((users) => {
            userService.organizeArray(users)
                .then((newUsers) => {
                res.status(200).json({
                    newUsers
                });
            })
                .catch((error) => {
                res.status(400).json({
                    error
                });
            });
        })
            .catch((error) => {
            res.status(400).json({
                error
            });
        });
    });
};
