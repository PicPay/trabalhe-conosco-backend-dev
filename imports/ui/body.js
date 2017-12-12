import { Meteor } from 'meteor/meteor';
import { Template } from 'meteor/templating';
import { ReactiveVar } from 'meteor/reactive-var';
import { ReactiveDict } from 'meteor/reactive-dict';

import { UsersDB } from '../api/usersDB.js';

import './body.html';

Template.body.onCreated(function bodyOnCreated() {
  this.state = new ReactiveDict();
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
    console.log('Session: ' + Session.get('searchValue'))
    Meteor.subscribe("searchUsers", searchValue);
    return UsersDB.find({}, {
      sort: {
        Relevancia: 1,
        score: -1
      },
      limit: 30
    });
  }
});