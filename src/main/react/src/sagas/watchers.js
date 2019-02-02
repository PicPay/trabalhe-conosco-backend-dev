import { takeLatest } from 'redux-saga/effects';
import * as types from '../constants/actionTypes';

import {getUsersSaga, searchUsersSaga} from './userSaga';

export function* watchGetUsers() {
  yield takeLatest(types.GET_USERS_REQUEST, getUsersSaga);
}

export function* watchSearchUsers() {
  yield takeLatest(types.SEARCH_USERS_REQUEST, searchUsersSaga);
}