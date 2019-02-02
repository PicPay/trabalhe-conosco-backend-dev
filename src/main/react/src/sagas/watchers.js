import { takeLatest } from 'redux-saga/effects';
import * as types from '../constants/actionTypes';

import { searchUsersSaga} from './userSaga';

export function* watchSearchUsers() {
  yield takeLatest(types.SEARCH_USERS_REQUEST, searchUsersSaga);
}