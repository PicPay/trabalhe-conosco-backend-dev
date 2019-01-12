'use strict';

var assert  = require('assert');
var fs = require('fs');
var EasyXml = require('../index.js');

describe("Array Unwrapping", function () {
  it("should be able to use unwrapped child nodes to represent an array", function() {
    var easyXML = new EasyXml({
      unwrapArrays: true,
      indent: 4
    });

    var before = {
      many: [
        "One",
        "Two"
      ],
      single: [
        "JustMe"
      ],
      deeper: {
        many: [
          {
            one:{
              _id: 1,
              _: "Uno"
            }
          },
          {
            two: {
              _id: 2,
              _: "Dos"
            }
          }
        ],
        single: [
          {
            three: {
              _id: 3,
              _: "Tres"
            }
          }
        ]
      }
    };

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/unwrapArrays.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("should normally wrap array elements in a single parent element", function() {
    var easyXML = new EasyXml({
      unwrapArrays: false,
      indent: 4
    });

    var before = {
      many: [
        "One",
        "Two"
      ],
      single: [
        "JustMe"
      ],
      deeper: {
        many: [
          {
            one:{
              _id: 1,
              _: "Uno"
            }
          },
          {
            two: {
              _id: 2,
              _: "Dos"
            }
          }
        ],
        single: [
          {
            three: {
              _id: 3,
              _: "Tres"
            }
          }
        ]
      }
    };

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/wrappedArrays.xml', 'utf8');

    assert.strictEqual(after, expected);
  });
});
