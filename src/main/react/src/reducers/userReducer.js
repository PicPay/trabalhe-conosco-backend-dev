import initialState from './initialState';
import * as types from '../constants/actionTypes';

export default function (state = initialState.users, action) {
  switch (action.type) {
    case types.GET_USERS_SUCCESS: {      
      return action.users;
    }    
    case types.SEARCH_USERS_SUCCESS: {
      return action.users;
    }
    default:
      return state;
  }
}