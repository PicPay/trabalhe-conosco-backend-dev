"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const userservice_1 = require("./../../services/user/userservice");
class UserServiceSingleton {
    constructor() { }
    static get Instance() {
        if (this.instance === null || this.instance === undefined) {
            this.instance = new userservice_1.UserService();
        }
        return this.instance;
    }
}
exports.UserServiceSingleton = UserServiceSingleton;
