"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const loginrepository_1 = require("./../../database/repositories/loginrepository");
class LoginRepositorySingleton {
    constructor() { }
    static get Instance() {
        if (this.instance === null || this.instance === undefined) {
            this.instance = new loginrepository_1.LoginRepository();
        }
        return this.instance;
    }
}
exports.LoginRepositorySingleton = LoginRepositorySingleton;
