import * as types from '../constants/actionTypes';

export const searchUsersAction = (text, page, size) => ({
  type: types.SEARCH_USERS_REQUEST,
  text,
  page, 
  size
});