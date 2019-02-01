import { fork, all } from 'redux-saga/effects';
import {watchGetUsers} from './watchers'

export default function* rootSaga() {
  yield all([
      fork(watchGetUsers)      
    ]
  );
}