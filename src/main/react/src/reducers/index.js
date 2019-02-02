import { combineReducers } from 'redux';
import users from './userReducer';
import message from './messageReducer';

const rootReducer = combineReducers({
    users,    
    message
});

export default rootReducer;