import Vue from 'vue'
import VueFormly from 'vue-formly'
import VueFormlyBuefy from 'vue-formly-buefy'
import Buefy from 'buefy'
import socketio from 'socket.io-client'
import VueSocketIO from 'vue-socket.io'
import VueHotkey from 'v-hotkey'

import App from '@/App.vue'
import router from '@/router'
import store from '@/store'
import nprogress from '@/config/nprogress'
// eslint-disable-next-line
import auth from '@/config/auth'
// eslint-disable-next-line
import directives from '@/config/directives'
// eslint-disable-next-line
import filters from '@/config/filters'

Vue.config.debug = process.env.DEBUG_MODE
Vue.config.productionTip = false

let socket_endpoint =
  location.protocol + '//' + document.domain + ':' + location.port + '/loader'

export const SocketInstance = socketio(socket_endpoint)

Vue.use(VueSocketIO, SocketInstance, store)
Vue.use(Buefy, { defaultIconPack: 'fa' })
Vue.use(VueFormly)
Vue.use(VueFormlyBuefy)
Vue.use(VueHotkey)

new Vue({
  router,
  nprogress,
  render: h => h(App)
}).$mount('#app')
