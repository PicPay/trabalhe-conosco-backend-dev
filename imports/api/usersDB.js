import { Meteor } from 'meteor/meteor';
import { Mongo } from 'meteor/mongo';
import { Restivus } from 'meteor/nimble:restivus'

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
    // let Api = new Restivus({
    //     // useDefaultAuth: true,
    //     prettyJson: true
    // });

    // Api.addCollection(UsersDB);

    // Api.addCollection(Meteor.users, {
    //     excludedEndpoints: ['getAll', 'put'],
    //     routeOptions: {
    //         authRequired: true
    //     },
    //     endpoints: {
    //         post: {
    //             authRequired: false
    //         },
    //         delete: {
    //             roleRequired: 'admin'
    //         }
    //     }
    // });

    // Api.addRoute('userss',
    //     { authRequired: true },
    //     {
    //         get: function () {
    //             return 'abra';
    //         }
    //     });



    ngram = (text) => {
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

    Meteor.publish('searchUsers', (par) => {
        if (!par[0]) {
            return UsersDB.find({}, { skip: 15*par[1], limit: 15 })
        }
        let searchGram = ngram(par[0]).join(' ');
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
                skip: 15*par[1],
                limit: 15
            },
        );
        return cursor;
    })
}