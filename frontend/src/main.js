import Vue from 'vue'
import App from './App'
import router from './router'
import VueResource from 'vue-resource';

Vue.config.productionTip = false

import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'

Vue.use(VueResource);

Vue.use(VueMaterial)

new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})

