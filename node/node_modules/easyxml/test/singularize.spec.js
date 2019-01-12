'use strict';

var assert  = require('assert');
var fs = require('fs');
var EasyXml = require('../index.js');

describe("Singularize", function () {
  it("should parse a JSON object without singularize to XML", function() {
    var easyXML = new EasyXml({
      singularize: false,
      indent: 4
    });

    var before = {
      CmsUsers: [
        { user: "user1" },
        { user: "user2" }
      ]
    };

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/singularize.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should parse a JSON object without singularize to XML (with object)", function() {
    var easyXML = new EasyXml({
      singularize: false,
      indent: 4
    });

    var before = {
      CmsUsers: [
        { user: { name: 'user1' } },
        { user: { name: 'user2' } }
      ]
    };

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/singularize2.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should parse a JSON object with correct captalization", function() {
    var easyXML = new EasyXml({
      singularize: true,
      indent: 4
    });

    var before = {
      Users: [
        { name: "user1" },
        { name: "user2" }
      ]
    };

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/singularize3.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should parse a JSON object and correctly nest child nodes", function() {
    var easyXML = new EasyXml({
      singularize: false,
      indent: 4
    });

    var before = {
      CmsUsers: [
        {
          user: {
            name: "user1",
            email: "user1@example.com"
          }
        },
        {
          user: {
            name: "user2",
            email: "user2@example.com"
          }
        }
      ]
    };

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/singularizeMultipleProperties.xml', 'utf8');

    assert.strictEqual(after, expected);
  });
});
