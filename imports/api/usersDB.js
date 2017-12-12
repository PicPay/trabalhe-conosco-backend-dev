import { Meteor } from 'meteor/meteor';
import { Mongo } from 'meteor/mongo';
// import { trigram } from 'n-gram';


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

// if (Meteor.isServer) {
//     let Api = new Restivus({
//         useDefaultAuth: true,
//         prettyJson: true
//     });

//     Api.addCollection(UsersDB);

//     Api.addCollection(Meteor.users, {
//         excludedEndpoints: ['getAll', 'put'],
//         routeOptions: {
//             authRequired: true
//         },
//         endpoints: {
//             post: {
//                 authRequired: false
//             },
//             delete: {
//                 roleRequired: 'admin'
//             }
//         }
//     });

//     Api.addRoute('UsersDB', { authRequired: true }, {
//         get: function () {
//             return getUsers(this.urlParams.id); 
//         }
//     });  
// }

if (Meteor.isServer) {
    UsersDB.rawCollection().createIndex({
        Hash: 'text',
        Relevancia: 1
    })

    trigram = (text) => {
        let grams = [];
        let index;
        let n = 4
        index = text.length - (n-1);
        if (index < 1) {
          return [text]
        }
        while (index--) {
          grams[index] = text.substr(index, n);
        }
        return grams;
      }

    Meteor.publish('searchUsers', (searchValue) => {
        console.log("Searching for ", searchValue);
        if (!searchValue) {
            return UsersDB.find({})
        }
        let searchGram = trigram(searchValue).join(' ');
        let cursor = UsersDB.find(
            {$text: { $search: searchGram } },
            {
                fields: {
                    score: { $meta: "textScore" }
                },
                sort: {
                    Relevancia: 1,
                    score: { $meta: "textScore" }
                },
                limit: 30
            },
        );
        return cursor;
    })
}