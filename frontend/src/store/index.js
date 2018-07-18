import Vue from 'vue'
import Vuex from 'vuex'
import users from "./users";

Vue.use(Vuex)

const state = {
  connect: false,
  status: null
}

const getters = {
  connected: state => state.connect,
  status: state => state.status
}

const mutations = {
  SOCKET_CONNECT: state => {
    state.connect = true
  },
  SOCKET_STATUS_UPDATE: (state, status) => {
    state.status = status[0]
  }
}

export default new Vuex.Store({
  state,
  getters,
  mutations,
  modules: {
    users
  }
})
