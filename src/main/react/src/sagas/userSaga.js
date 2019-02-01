import { put, call } from 'redux-saga/effects';
import { getAllUsers } from '../Api/api';
import * as types from '../constants/actionTypes';
import Chance from 'chance';

const chance = new Chance();

export function* getUsersSaga() {
    const response = yield call(getAllUsers);
    if(!response.error){  
      let users = response.map(({ id, userName, name, priority }) => {        
        return {
          _id: chance.guid(),
          id,
          userName,
          name,
          priority
        }
      });
      let message = {text: response.length + ' users loaded.', messageType: 'INFO', show: true}            
      yield [
        put({ type: types.GET_USERS_SUCCESS, users }),
        put({ type: types.SHOW_MESSAGE, message })
      ];
    } else {        
      let message = {text: response.error, messageType: 'FAILURE', show: true}      
      yield [
        put({ type: types.GET_USERS_FAILURE, response }),
        put({ type: types.SHOW_MESSAGE, message })
      ]
    }  
}