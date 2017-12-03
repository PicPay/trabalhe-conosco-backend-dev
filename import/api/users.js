import { Meteor } from 'meteor/meteor';


export const Users = new Mongo.Collection("users");

var userSchema = new SimpleSchema({
    _id: {
        type: String,
        label: "ID",
        min: 1,
        max: 36
    },
    Nome: {
        type: String,
        label: "Nome",
        min: 1,
        max: 50
    },
    Username: {
        type: String,
        label: "Username",
        min: 1,
        max: 50
    },
    Relevancia: {
        type: Number,
        label: "Relevancia",
        min: 1,
        max: 3
    }
});

export const userContext = userSchema.newContext()
