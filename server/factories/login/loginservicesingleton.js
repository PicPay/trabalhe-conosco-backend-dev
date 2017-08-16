"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const loginservice_1 = require("./../../services/login/loginservice");
class LoginServiceSingleton {
    constructor() { }
    static get Instance() {
        if (this.instance === null || this.instance === undefined) {
            this.instance = new loginservice_1.LoginService();
        }
        return this.instance;
    }
}
exports.LoginServiceSingleton = LoginServiceSingleton;
