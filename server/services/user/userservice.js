"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const userrepository_1 = require("./../../database/repositories/userrepository");
const ormsingleton_1 = require("./../../factories/orm/ormsingleton");
const fs = require("fs");
const readline = require("readline");
let orm = ormsingleton_1.OrmSingleton.Instance;
class UserService {
    findByNome(nome, skip) {
        return new Promise((resolve, reject) => {
            orm.getConnection().then((connection) => {
                connection.getCustomRepository(userrepository_1.UserRepository).findByNome(nome, skip).then((users) => {
                    return resolve(users);
                }).catch((error) => {
                    return reject(error);
                });
            });
        });
    }
    organizeArray(users) {
        return new Promise((resolve, reject) => {
            this.priority(users, 1)
                .then((userPriority1) => {
                this.priority(users, 2)
                    .then((userPriority2) => {
                    let newOrder = userPriority1.concat(userPriority2, users);
                    return resolve(newOrder);
                });
            })
                .catch((error) => { });
        });
    }
    priority(users, pos) {
        return new Promise((resolve, reject) => {
            let userPriority = [];
            let interfaceArq = readline.createInterface({
                input: fs.createReadStream(__dirname + '/lista_relevancia_' + pos + '.txt')
            });
            var lineno = 0;
            interfaceArq.on('line', function (line) {
                lineno++;
                let found = users.find(element => {
                    //console.log('pos => ' + pos + ' id => ' + element.Id + ' line => ' + line)
                    return element.Id == line;
                });
                //console.log('found => ' + found)
                if (found) {
                    //console.log('achou')
                    userPriority.push(found);
                    let pos = users.indexOf(found);
                    if (pos) {
                        users.splice(pos, 1);
                    }
                }
            });
            interfaceArq.on('close', function () {
                return resolve(userPriority);
            });
        });
    }
}
exports.UserService = UserService;
