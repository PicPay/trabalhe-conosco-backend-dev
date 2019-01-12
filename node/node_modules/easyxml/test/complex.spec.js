'use strict';

var assert  = require('assert');
var fs = require('fs');
var EasyXml = require('../index.js');

describe("Complex Operations", function () {
  it("should handle a more complex object", function() {
    var before = require('./fixtures/complex.json');

    var easyXML = new EasyXml({
      indent: 4
    });

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/complex.xml', 'utf8');

    assert.strictEqual(after, expected);
  });

  it("generates a Cordova compatible document", function() {
    var before = {
      '_id': 'com.may.app',
      '_version': '1.0.0',
      'author': {
        _email: "feedback@my.com",
        _href: "http://my.com",
        _: 'My Team'
      },
      'description': 'My Mobile Application',
      'content': {
        _src: "index.html"
      },
      'preference': [
        {_name: 'phonegap-version', _value: 'cli-5.1.1'},
        {_name: 'permissions', _value: 'none'}
      ],
      'gap:plugin': [
        {_name:"org.apache.cordova.battery-status"},
        {_name: "org.apache.cordova.camera"}
      ]
    };

    var easyXML = new EasyXml({
      manifest: true,
      unwrapArrays: true,
      rootElement: 'widget'
    });

    var after = easyXML.render(before);

    var expected = fs.readFileSync('./test/fixtures/cordova.xml', 'utf8');

    assert.strictEqual(after, expected);
  });
});
