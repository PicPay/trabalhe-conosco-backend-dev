"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const loginrepository_1 = require("./../../database/repositories/loginrepository");
const ormsingleton_1 = require("./../../factories/orm/ormsingleton");
const login_1 = require("./../../database/entities/login");
var jwt = require('jsonwebtoken');
let orm = ormsingleton_1.OrmSingleton.Instance;
class LoginService {
    createToken(user) {
        return new Promise((resolve, reject) => {
            let token = jwt.sign(user.Senha, user.Login, { algorithm: 'HS512' }, {});
            if (token)
                return resolve(token);
            else
                return reject("Token wasn't created");
        });
    }
    createUser(userComumReq) {
        return new Promise((resolve, reject) => {
            let userComum = new login_1.UserComum();
            userComum.Login = userComumReq.Login;
            userComum.Senha = userComumReq.Senha;
            this.createToken(userComumReq)
                .then((token) => {
                userComum.Token = token;
            }).catch((error) => {
                return reject(error);
            });
            orm.getConnection().then((connection) => {
                connection.getCustomRepository(loginrepository_1.LoginRepository).save(userComum)
                    .then((user) => {
                    return resolve(user.Token);
                }).catch((error) => {
                    return reject(error);
                });
            });
        });
    }
    verifyToken(token) {
        return new Promise((resolve, reject) => {
            orm.getConnection().then((connection) => {
                connection.getCustomRepository(loginrepository_1.LoginRepository).findByToken(token)
                    .then((sucess) => {
                    if (sucess) {
                        if (token)
                            jwt.verify(token, sucess.Login, (err, decoded) => {
                                if (err) {
                                    let error = {
                                        message: "Token expired",
                                        expiredAt: err.expiredAt
                                    };
                                    return reject(error);
                                }
                                else
                                    resolve(true);
                            });
                        else
                            return reject('Token invalid');
                    }
                    else
                        return reject('Token invalid');
                })
                    .catch((error) => {
                    return reject('Token invalid');
                });
            });
        });
    }
}
exports.LoginService = LoginService;
