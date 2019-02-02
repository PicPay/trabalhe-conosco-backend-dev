import { put, call } from 'redux-saga/effects';
import { searchUsers } from '../Api/api';
import * as types from '../constants/actionTypes';
import Chance from 'chance';

const chance = new Chance();

export function* searchUsersSaga(action) {
  const response = yield call(searchUsers, action.text, action.page, action.size)
  if(!response.error){  
    let users = response.content.map(({ id, userName, name, priority }) => {        
      return {
        _id: chance.guid(),
        id,
        userName,
        name,
        priority
      }
    });    
    let message = {text: users.length + ' users loaded.', messageType: 'INFO', show: true}            
    yield [
      put({ type: types.SEARCH_USERS_SUCCESS, users, text: action.text, page: response.number, totalElements: response.totalElements, totalPages: response.totalPages}),
      put({ type: types.SHOW_MESSAGE, message })
    ];
  } else {        
    let message = {text: response.error, messageType: 'FAILURE', show: true}      
    yield [
      put({ type: types.SEARCH_USERS_FAILURE, response }),
      put({ type: types.SHOW_MESSAGE, message })
    ]
  }  
}

