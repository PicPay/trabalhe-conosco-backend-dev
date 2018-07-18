import Vue from 'vue'
import NProgress from 'vue-nprogress'

Vue.use(NProgress)

export default new NProgress({ parent: '.nprogress-container' })