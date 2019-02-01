import { takeLatest } from 'redux-saga/effects';
import * as types from '../constants/actionTypes';

import {getUsersSaga} from './userSaga';

export function* watchGetUsers() {
  yield takeLatest(types.GET_USERS_REQUEST, getUsersSaga);
}