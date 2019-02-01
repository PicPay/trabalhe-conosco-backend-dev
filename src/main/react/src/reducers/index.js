import { combineReducers } from 'redux';
import users from './userReducer';
import message from './messageReducer';
import filter from './filterReducer';

const rootReducer = combineReducers({
    users,    
    message,
    filter    
});

export default rootReducer;