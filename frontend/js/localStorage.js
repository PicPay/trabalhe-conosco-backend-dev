app.factory('$localStorage', ['$window', function($window) {
  return {
    set: function(key, value) {
        $window.localStorage[key] = value;
        return $window.localStorage[key];
    },

    get: function(key, defaultValue) {
        return $window.localStorage[key] || defaultValue;
    },

    // gravo em json
    setObject: function(key, value) {
        $window.localStorage[key] = JSON.stringify(value);
    },

    // recupero em objeto
    getObject: function(key) {
        return JSON.parse($window.localStorage[key] || null);
    }
  }
}]);