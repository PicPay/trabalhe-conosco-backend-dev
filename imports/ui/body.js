import { Meteor } from 'meteor/meteor';
import { Template } from 'meteor/templating';
import { ReactiveVar } from 'meteor/reactive-var';
import { ReactiveDict } from 'meteor/reactive-dict';

import { UsersDB } from '../api/usersDB.js';

import './body.html';

let HttpClient = function () {
  this.get = function (aUrl, aCallback) {
    var anHttpRequest = new XMLHttpRequest();
    anHttpRequest.onreadystatechange = function () {
      if (anHttpRequest.readyState == 4 && anHttpRequest.status == 200)
        aCallback(anHttpRequest.responseText);
    }

    anHttpRequest.open("GET", aUrl, true);
    anHttpRequest.send(null);
  }
}

Template.body.onCreated(function bodyOnCreated() {
  this.state = new ReactiveDict();
  Session.set("pag", 0);
  Session.set("users", []);
});

Template.body.events({
  'click .AddPlaceButton1': function (e) {
    e.preventDefault();
    if (Session.get("pag") > 0) {
      Session.set("pag", Session.get("pag") - 1);
    }
  },
  'click .AddPlaceButton2': function (e) {
    e.preventDefault();
    Session.set("pag", Session.get("pag") + 1);
  }
});

Template.search.events({
  'submit .search-form'(event) {
    event.preventDefault();
    Session.set("pag", 0);
    Session.set("searchValue", $("#searchValue").val());
  }
});


Template.search.helpers({
  users: () => {
    let searchValue = Session.get('searchValue')
    let pag = Session.get("pag")
    let client = new HttpClient()
    getURL = 'http://localhost:3000/api/Users/?search='+searchValue+'&pag='+ pag.toString()+'&userid='+Meteor.userId() 

    client.get(getURL, (response) => {
      Session.set("users", JSON.parse(response));
    });
    return Session.get("users")
  }
});