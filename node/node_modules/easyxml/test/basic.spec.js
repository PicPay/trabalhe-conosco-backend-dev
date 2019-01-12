'use strict';

var assert  = require('assert');
var fs = require('fs');
var EasyXml = require('../index.js');

describe("Basic Operations", function () {
  it("allows root overriding at time of rendering", function() {
    var before = {
      a: true
    };

    var easyXML = new EasyXml({
      rootElement: 'x',
      indent: 0
    });

    var after = easyXML.render(before, 'y');

    assert.equal(after, "<y>\n<a>true</a>\n</y>\n");
  });

  it("throws with bad attribute", function() {
    var before = {
      a: 1,
      _b: {}
    };

    var easyXML = new EasyXml();

    assert.throws(function() {
      easyXML.render(before);
    }, /non_string_attribute/);
  });

  it("should parse a JSON object into XML", function() {
    var before = {
      names: [
        "Tom",
        "Josh"
      ]
    };

    var easyXML = new EasyXml({
      indent: 4
    });

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/names.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should parse a JSON object with attrs into XML", function() {
    var before = {
      user: {
        _id: 1,
        name: "Tom"
      }
    };

    var easyXML = new EasyXml({
      indent: 4
    });

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/names1.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should parse a JSON object with attrs and text node into XML", function() {
    var before = {
      user: {
        _id: 1,
        _: "Tom"
      }
    };

    var easyXML = new EasyXml({
      indent: 4
    });

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/names2.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should parse a null value", function() {
    var before = {
      boolz: true,
      nullz: null, 
      nullEls : [
        null
      ]
    };

    var easyXML = new EasyXml({
      indent: 4
    });

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/null.xml', 'utf8');

    assert.strictEqual(after, expected);
  });
});
