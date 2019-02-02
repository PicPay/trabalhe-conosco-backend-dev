import { fork, all } from 'redux-saga/effects';
import {watchGetUsers, watchSearchUsers} from './watchers'

export default function* rootSaga() {
  yield all([
      fork(watchGetUsers),
      fork(watchSearchUsers)  
    ]
  );
}