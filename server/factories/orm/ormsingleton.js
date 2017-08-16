"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const connection_1 = require("./../../database/connection");
class OrmSingleton {
    constructor() { }
    static get Instance() {
        if (this.instance === null || this.instance === undefined) {
            this.instance = new connection_1.OrmDatabase();
        }
        return this.instance;
    }
}
exports.OrmSingleton = OrmSingleton;
