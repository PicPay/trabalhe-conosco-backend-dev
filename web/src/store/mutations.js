import * as types from './mutation-types';

export const mutations = {
  [types.REGISTER] (state) {
    state.registerStatus = 'pending';
    state.registerFailureMessage = '';
    state.isLoggedIn = false;
  },
  [types.REGISTER_SUCCESS] (state) {
    state.registerStatus = 'success';
    state.isLoggedIn = true;
  },
  [types.REGISTER_FAILURE] (state, msg) {
    state.registerStatus = 'fail';
    state.registerFailureMessage = msg;
  },


  [types.LOGIN] (state) {
    state.loginStatus = 'pending';
    state.loginFailureMessage = '';
    state.isLoggedIn = false;
  },
  [types.LOGIN_SUCCESS] (state) {
    state.loginStatus = 'success';
    state.isLoggedIn = true;
  },
  [types.LOGIN_FAILURE] (state, msg) {
    state.loginStatus = 'fail';
    state.loginFailureMessage = msg;
  },


  [types.LOGOUT] (state) {
    state.isLoggedIn = false;
  },


  [types.GET_USERS] (state) {
    state.getUsersStatus = 'pending';
    state.getUsersFailureMessage = '';
  },
  [types.CLEAR_USERS] (state) {
    state.usersMeta = {};
    state.usersList = [];
  },
  [types.GET_USERS_SUCCESS] (state, { meta, records }) {
    state.getUsersStatus = 'success';
    state.usersMeta = meta;
    state.usersList = records;
  },
  [types.GET_USERS_FAILURE] (state, msg) {
    state.getUsersStatus = 'fail';
    state.fetchAPIFailureMessage = msg;
    state.usersMeta = {};
    state.usersList = [];
  }
};
