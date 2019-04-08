import { combineReducers } from 'redux';

import { authentication } from './authentication.reducer';
import { users } from './user.reducer';
import { alert } from './alert.reducer';

import login from "./loginReducer"

const rootReducer = combineReducers({
  authentication,
  users,
  alert,
  login
});

export default rootReducer;