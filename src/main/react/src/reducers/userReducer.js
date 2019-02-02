import initialState from './initialState';
import * as types from '../constants/actionTypes';
import update from 'react-addons-update';

export default function (state = initialState.user, action) {
  switch (action.type) {
    case types.SEARCH_USERS_SUCCESS: {
      return update(state, {users: {$set: action.users}, text: {$set: action.text}, page: {$set: action.page}, totalElements: {$set: action.totalElements}, totalPages: {$set: action.totalPages}});
    }
    default:
      return state;
  }
}