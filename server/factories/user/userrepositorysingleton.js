"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const userrepository_1 = require("./../../database/repositories/userrepository");
class UserRepositorySingleton {
    constructor() { }
    static get Instance() {
        if (this.instance === null || this.instance === undefined) {
            this.instance = new userrepository_1.UserRepository();
        }
        return this.instance;
    }
}
exports.UserRepositorySingleton = UserRepositorySingleton;
