import Vue from 'vue'
import vueMoment from 'vue-moment'
import moment from 'moment'

moment.locale('pt-Br')
Vue.use(vueMoment, {
  moment
})
