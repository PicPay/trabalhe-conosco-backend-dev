import Vue from 'vue'

const SET_USERS = 'SET_USERS'
const SET_TOTAL = 'SET_TOTAL'

const state = {
  list: [],
  total: 0
}

const getters = {
  list: state => state.list,
  total: state => state.total
}

const mutations = {
  [SET_USERS]: (state, users) => {
    state.list = users
  },
  [SET_TOTAL]: (state, total) => {
    state.total = total
  }
}

const actions = {
  getUsers({ commit }, data) {
    Vue.axios
      .get('usuario', {
        params: {
          key: data.keyword,
          skip: data.skip
        }
      })
      .then(res => {
        if (res.status >= 200 && res.status < 300) {
          commit(SET_USERS, res.data)
          commit(SET_TOTAL, res.headers['content-range'].replace(/.*\//i, ''))
        }
      })
      .catch(error => {
        return Promise.reject(error)
      })
  }
}

const users = {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}

export default users
