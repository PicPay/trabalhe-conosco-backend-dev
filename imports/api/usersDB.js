import { Meteor } from 'meteor/meteor';
import { Mongo } from 'meteor/mongo';


export const UsersDB = new Mongo.Collection("usersDB");

const userDBSchema = new SimpleSchema({
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
        // text: true
    },
    Username: {
        type: String,
        label: "Username",
        min: 1,
        max: 50
        // text: true
    },
    Hash: {
        type: String,
        label: "N-grams",
        min: 1
    },
    Relevancia: {
        type: Number,
        label: "Relevancia",
        min: 1,
        max: 3
    }
});

export const userDBContext = userDBSchema.newContext()

if (Meteor.isServer) {
    UsersDB.rawCollection().createIndex({
        // Nome: 'text',  
        // username: 'text'
        Hash: 'text'
    })
    Meteor.publish('searchUsers', (searchValue) => {
        console.log("Searching for ", searchValue);
        if (!searchValue) {
            return UsersDB.find({})
        }
        var cursor = UsersDB.find(
            { $text: { $search: searchValue } },
            {
                fields: {
                    score: { $meta: "textScore" }
                },
                sort: {
                    score: { $meta: "textScore" }
                }
            }
        );
        return cursor;
    })
}