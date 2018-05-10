import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './router/'
import Buefy from 'buefy'
import VueResource from 'vue-resource'
import App from './App'

import 'buefy/lib/buefy.css'
import 'mdi/css/materialdesignicons.min.css'

Vue.config.productionTip = false
Vue.use(Buefy)
Vue.use(VueRouter);
Vue.use(VueResource);

let app = new Vue({
    el: '#vueApp',
    router,
    template: '<App/>',
    components: { App }
})