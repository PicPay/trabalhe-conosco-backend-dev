'use strict';

var assert  = require('assert');
var fs = require('fs');
var EasyXml = require('../index.js');

describe("Undefined Values", function () {
  it("Handling undefined in arrays and as elements", function() {
    var before = {
      undef: undefined,
      undefObj: {
        undefSubKey: undefined
      },
      undefs: [
        undefined,
        null,
        'not-null'
      ],
      undef1s:[
        undefined,
        null
      ]
    };

    var easyXML = new EasyXml({
      unwrapArrays: false,
      indent: 4
    });

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/undefinedHandling.xml', 'utf8');

    assert.equal(after, expected);
  });

  it("Handling undefined in arrays and as elements", function() {
    var before = {
      undef: undefined,
      undefObj: {
        undefSubKey: undefined
      },
      undefs: [
        undefined,
        null,
        'not-null'
      ],
      undef1s:[
        undefined,
        null
      ]
    };

    var easyXML = new EasyXml({
      unwrapArrays: false,
      filterNulls: true,
      indent: 4
    });

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/undefinedHandlingFiltered.xml', 'utf8');

    assert.equal(after, expected);
  });
});
