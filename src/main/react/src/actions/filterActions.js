import * as types from '../constants/actionTypes';

export const searchText = (text) => ({
  type: types.SEARCH_TEXT,
  filter: {searchText: text}
})