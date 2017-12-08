import { Meteor } from 'meteor/meteor';
import { Template } from 'meteor/templating';
import { ReactiveVar } from 'meteor/reactive-var';
import { ReactiveDict } from 'meteor/reactive-dict';


import { UsersDB } from '../api/usersDB.js';

import './body.html';

Template.body.onCreated(function bodyOnCreated() {
    this.state = new ReactiveDict();
  });

// Template.hello.onCreated(function helloOnCreated() {
//   // counter starts at 0
//   this.counter = new ReactiveVar(0);
// }); 

// Template.hello.helpers({
//   counter() {
//     return Template.instance().counter.get();
//   },
// });

// Template.hello.events({
//   'click button'(event, instance) {
//     // increment the counter when button is clicked
//     instance.counter.set(instance.counter.get() + 1);
//   },
// });


Template.search.events({
  'submit .search-form'(event) {
    // console.log(event.target)
    // event.preventDefault();
    Session.set("searchValue", $("#searchValue").val());
    console.log('Session: ' + Session.get('searchValue'))
    // target.searchValue.value = '';
  }
});


Template.search.helpers({
  users: () => {
    Meteor.subscribe("searchUsers", Session.get('searchValue'));
    if (Session.get("searchValue")) {
      return UsersDB.find({}, { sort: [["score", "desc"]] });
    } else {
      return UsersDB.find({});
    }
  }
});

// Template.search.helpers({
//   users: () => {
//     Meteor.subscribe("searchUsers");
//     return UsersDB.find({});
//   }
// });