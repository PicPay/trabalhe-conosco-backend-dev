import initialState from './initialState';
import * as types from '../constants/actionTypes';

export default function (state = initialState.message, action) {
  switch (action.type) {    
    case types.SHOW_MESSAGE: { 
        return {text: action.message.text, show: action.message.show, messageType: action.message.messageType};        
    }
    default:
      return state;
  }
}