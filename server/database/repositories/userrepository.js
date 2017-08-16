"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
const user_1 = require("./../entities/user");
const typeorm_1 = require("typeorm");
const AbstractRepository_1 = require("typeorm/repository/AbstractRepository");
let UserRepository = class UserRepository extends AbstractRepository_1.AbstractRepository {
    findByNome(nome, skip) {
        if (skip < 0)
            skip = 1;
        return this.manager.createQueryBuilder(user_1.UserPicpay, "UserPicpay")
            .where("UserPicpay.Nome LIKE '%" + nome + "%' or UserPicpay.Username LIKE '%" + nome + "%'")
            .skip((skip * 15) - 15)
            .take(15).getMany();
    }
};
UserRepository = __decorate([
    typeorm_1.EntityRepository(user_1.UserPicpay)
], UserRepository);
exports.UserRepository = UserRepository;
