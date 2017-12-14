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
    },
    Hash: {
        type: String,
        label: "N-grams",
        optional: true
    }
});

export const userDBContext = userDBSchema.newContext()


if (Meteor.isServer) {
    let ngram = (text) => {
        let grams = [];
        let index;
        let n = 4
        index = text.length - (n - 1);
        if (index < 1) {
            return [text]
        }
        while (index--) {
            grams[index] = text.substr(index, n);
        }
        return grams;
    }
    
    let getCursor = (searchValue, pag) => {
        if (!searchValue) {
            return UsersDB.find({}, {skip: 15*pag, limit: 15 }).fetch()
        }
        let searchGram = ngram(searchValue).join(' ');
        let cursor = UsersDB.find(
            { $text: { $search: searchGram } },
            {
                fields: {
                    score: { $meta: "textScore" }
                },
                sort: {
                    Relevancia: 1,
                    score: { $meta: "textScore" }
                },
                skip: 15*pag,
                limit: 15
            },
        ).fetch();
        return cursor;
    }

    let Api = new Restivus({
        prettyJson: true
    });

    Api.addCollection(UsersDB);

    Api.addRoute('Users',
        {
            get: function () {
                let query = this.queryParams;
                if (Meteor.users.find({_id: query.userid}).count()) {
                return getCursor(query.search, query.pag)
                }
                return 'You must be logged in to do this'
            }
        });
}