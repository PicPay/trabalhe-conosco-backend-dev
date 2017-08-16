"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const loginservicesingleton_1 = require("./../factories/login/loginservicesingleton");
module.exports = (app) => {
    let loginService = loginservicesingleton_1.LoginServiceSingleton.Instance;
    app.route('/add').post((req, res, next) => {
        loginService.createUser(req.body.UserComumReq)
            .then((token) => {
            res.status(200).json({
                token
            });
        }).catch((error) => {
            res.status(400).json({
                error
            });
        });
    });
};
