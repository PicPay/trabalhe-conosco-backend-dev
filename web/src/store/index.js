import Vue from 'vue';
import Vuex from 'vuex';
import { mutations } from './mutations';
import * as actions from './actions';
import * as getters from './getters';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    usersList: [],
    usersMeta: {},
    isLoggedIn: !!localStorage.getItem('access_token'),
    getUsersStatus: '',
    registerStatus: '',
    loginStatus: '',
    getUsersFailureMessage: '',
    registerFailureMessage: '',
    loginFailureMessage: ''
  },
  mutations,
  actions,
  getters
});
