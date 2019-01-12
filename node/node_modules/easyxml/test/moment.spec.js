'use strict';

var assert  = require('assert');
var EasyXml = require('../index.js');
var moment = require('moment');

describe("Moment.js", function () {
  it("properly serializes a moment.js object", function() {
    var before = {
      date: moment("2016-02-06 21:03:00")
    };

    var easyXML = new EasyXml();

    var after = easyXML.render(before);

    assert.equal(after, "<response>\n  <date>2016-02-07T05:03:00.000Z</date>\n</response>\n");
  });
});
