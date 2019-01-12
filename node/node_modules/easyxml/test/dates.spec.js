'use strict';

var assert  = require('assert');
var EasyXml = require('../index.js');

describe("Date Operations", function () {
  it("parses native Date objects", function() {
    var before = {
      date: new Date('December 17, 1995 03:24:00')
    };

    var easyXML = new EasyXml({
      indent: 0
    });

    var after = easyXML.render(before);

    assert.equal(after, "<response>\n<date>1995-12-17T11:24:00.000Z</date>\n</response>\n");
  });

  it("provides a SQL friendly date string", function() {
    var before = {
      date: new Date('December 17, 1995 03:24:00')
    };

    var easyXML = new EasyXml({
      dateFormat: EasyXml.SQL,
      indent: 0
    });

    var after = easyXML.render(before);

    assert.equal(after, "<response>\n<date>1995-12-17 03:24:00</date>\n</response>\n");
  });

  it("provides an ugly JS date string", function() {
    var before = {
      date: new Date('December 17, 1995 03:24:00')
    };

    var easyXML = new EasyXml({
      dateFormat: EasyXml.JS,
      indent: 0
    });

    var after = easyXML.render(before);

    assert.equal(after, "<response>\n<date>Sun Dec 17 1995 03:24:00 GMT-0800 (PST)</date>\n</response>\n");
  });

  it("throws with bad date format", function() {
    var before = {
      now: new Date()
    };

    var easyXML = new EasyXml({
      dateFormat: 'XYZ'
    });

    assert.throws(function() {
      easyXML.render(before);
    }, /unknown_date_format/);
  });
});
