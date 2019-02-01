import initialState from './initialState';
import * as types from '../constants/actionTypes';
import update from 'react-addons-update';

export default function (state = initialState.filter, action) {
  switch (action.type) {    
    case types.SEARCH_TEXT: { 
        return update(state, {searchText: {$set: action.filter.searchText}});        
    }        
    default:
      return state;
  }
}