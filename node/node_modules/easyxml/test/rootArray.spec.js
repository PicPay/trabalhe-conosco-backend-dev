'use strict';

var assert  = require('assert');
var fs = require('fs');
var EasyXml = require('../index.js');

describe("Root is Array", function () {
  it("should work as expected when root is an array of objects", function() {
    var easyXML = new EasyXml({
      indent: 4
    });

    var before = [
      {
        name: "banana",
        _color: "yellow"
      },
      {
        name: "apple",
        _color: "red"
      }
    ];

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/rootArray1.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should work as expected when root is an array of strings", function() {
    var easyXML = new EasyXml({
      indent: 4
    });

    var before = ["one", "two", "three"];

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/rootArray2.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should allow renaming the root element when root is an array", function() {
    var before = [
      {
        name: "spot"
      },
      {
        name: "rover"
      }
    ];

    var easyXML = new EasyXml({
      rootArray: 'dogs',
      indent: 0
    });

    var after = easyXML.render(before, 'Kennel');

    assert.equal(after, "<Kennel>\n<dog>\n<name>spot</name>\n</dog>\n<dog>\n<name>rover</name>\n</dog>\n</Kennel>\n");
  });
});

