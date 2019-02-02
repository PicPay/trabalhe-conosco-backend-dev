import { fork, all } from 'redux-saga/effects';
import { watchSearchUsers} from './watchers'

export default function* rootSaga() {
  yield all([
      fork(watchSearchUsers)  
    ]
  );
}