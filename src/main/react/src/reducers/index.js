import { combineReducers } from 'redux';
import user from './userReducer';
import message from './messageReducer';

const rootReducer = combineReducers({
    user,    
    message,
});

export default rootReducer;