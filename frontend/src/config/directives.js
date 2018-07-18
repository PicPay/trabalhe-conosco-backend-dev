import Vue from 'vue';
Vue.directive('focus', {
  inserted: function(el) {
    if (el.tagName === 'INPUT') {
      el.focus();
    } else {
      el.querySelector('input').focus();
    }
  }
});
