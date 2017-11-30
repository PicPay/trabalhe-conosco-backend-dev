import { Meteor } from 'meteor/meteor';

export const Users = new Mongo.Collection("users");

var Schemas = {};

Schemas.Users = new SimpleSchema({
    _id: {
        type: String,
        label: "ID",
        min: 0,
        max: 36
    },
    Nome: {
        type: String,
        label: "Nome",
        min: 0,
        max: 50
    },
    Username: {
        type: String,
        label: "Username",
        min: 0,
        max: 50
    },
    Relevancia: {
        type: Number,
        label: "Relevancia",
        min: 1,
        max: 3
    }
});

Users.attachSchema(Schemas.Users);