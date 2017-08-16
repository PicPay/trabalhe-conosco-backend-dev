"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
const login_1 = require("./../entities/login");
const typeorm_1 = require("typeorm");
const AbstractRepository_1 = require("typeorm/repository/AbstractRepository");
let LoginRepository = class LoginRepository extends AbstractRepository_1.AbstractRepository {
    findByToken(token) {
        return this.repository.findOne({ Token: token });
    }
    save(user) {
        return this.manager.save(user);
    }
};
LoginRepository = __decorate([
    typeorm_1.EntityRepository(login_1.UserComum)
], LoginRepository);
exports.LoginRepository = LoginRepository;
