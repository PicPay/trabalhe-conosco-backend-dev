"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const login_1 = require("./entities/login");
const user_1 = require("./entities/user");
require("reflect-metadata");
const typeorm_1 = require("typeorm");
const options = {
    type: 'mssql',
    host: 'picpay.database.windows.net',
    username: 'userAdmin',
    password: "@@@123456aaa",
    database: "picpay",
    extra: { options: { encrypt: true } },
    logging: {
        logFailedQueryError: true,
        logQueries: true,
        logSchemaCreation: false,
        logOnlyFailedQueries: true
    },
    autoSchemaSync: true,
    entities: [user_1.UserPicpay, login_1.UserComum]
};
class OrmDatabase {
    getConnection() {
        return new Promise((resolve, reject) => {
            try {
                return resolve(typeorm_1.getConnection());
            }
            catch (e) {
                typeorm_1.createConnection(options).then(connection => {
                    return resolve(connection);
                }, (error) => {
                    console.log('e ' + e);
                    console.log('error ' + error);
                    return reject;
                });
            }
        });
    }
}
exports.OrmDatabase = OrmDatabase;
