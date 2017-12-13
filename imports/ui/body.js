import { Meteor } from 'meteor/meteor';
import { Template } from 'meteor/templating';
import { ReactiveVar } from 'meteor/reactive-var';
import { ReactiveDict } from 'meteor/reactive-dict';

import { UsersDB } from '../api/usersDB.js';

import './body.html';
import { stringify } from 'querystring';

Template.body.onCreated(function bodyOnCreated() {
  this.state = new ReactiveDict();
  Session.set("pag", 0);
});

Template.body.events({
  'click .AddPlaceButton1': function (e) {
    e.preventDefault();
    console.log("You pressed the button1");
    if (Session.get("pag") > 0) {
    Session.set("pag", Session.get("pag") - 1);
    console.log(Session.get("pag"))
    }
  },
  'click .AddPlaceButton2': function (e) {
    e.preventDefault();
    console.log("You pressed the button2");
    Session.set("pag", Session.get("pag") + 1);
    console.log(Session.get("pag"))
  }
});

Template.search.events({
  'submit .search-form'(event) {
    event.preventDefault();
    Session.set("searchValue", $("#searchValue").val());
  }
});


Template.search.helpers({
  users: () => {
    let searchValue = Session.get('searchValue')
    let pag = Session.get("pag")
    // console.log('Session: ')
    Meteor.subscribe("searchUsers", [searchValue, pag]);
    return UsersDB.find({}, {
      sort: {
        Relevancia: 1,
        score: -1
      },
      limit: 15
    });
  }
});

// let HttpClient = function() {
//   this.get = function(aUrl, aCallback) {
//       var anHttpRequest = new XMLHttpRequest();
//       anHttpRequest.onreadystatechange = function() { 
//           if (anHttpRequest.readyState == 4 && anHttpRequest.status == 200)
//               aCallback(anHttpRequest.responseText);
//       }

//       anHttpRequest.open( "GET", aUrl, true );            
//       anHttpRequest.send( null );
//   }
// }

// let client = new HttpClient();
// client.get('http://localhost:3000/api/userss/', (response) => {
//   console.log(response);
// });