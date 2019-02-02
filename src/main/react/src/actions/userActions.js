import * as types from '../constants/actionTypes';

export const getUsersAction = () => ({
  type: types.GET_USERS_REQUEST
});

export const searchUsersAction = (text) => ({
  type: types.SEARCH_USERS_REQUEST,
  text
})