"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const loginservicesingleton_1 = require("./../factories/login/loginservicesingleton");
let loginService = loginservicesingleton_1.LoginServiceSingleton.Instance;
module.exports = (app) => {
    app.use('/*', (req, res, next) => {
        loginService.verifyToken(req.headers['x-acess-token'])
            .then((sucess) => {
            next();
        })
            .catch((error) => {
            res.status(400).json({
                error
            });
        });
    });
};
