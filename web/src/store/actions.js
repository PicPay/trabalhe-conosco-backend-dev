import * as types from './mutation-types';
import api from '../api';

export function register({ commit }, { email, password }) {
  commit(types.REGISTER);

  api.post('/auth/register', { email, password })
    .then(res => res.data)
    .then(({ access_token }) => {
      localStorage.setItem('access_token', access_token);
      commit(types.REGISTER_SUCCESS);
    })
    .catch(({ response }) => {
      if (response && response.status === 409) {
        return commit(types.REGISTER_FAILURE, 'User already exists!');
      }

      commit(types.REGISTER_FAILURE, 'Oops! Something\'s wrong.');
    });
}

export function login({ commit }, { email, password }) {
  commit(types.LOGIN);

  api.post('/auth/login', { email, password })
    .then(res => res.data)
    .then(({ access_token }) => {
      localStorage.setItem('access_token', access_token);
      commit(types.LOGIN_SUCCESS);
    })
    .catch(({ response }) => {
      if (response && response.status === 404) {
        return commit(types.LOGIN_FAILURE, 'User not found!');
      } else if (response && response.status === 401) {
        return commit(types.LOGIN_FAILURE, 'Invalid password!');
      }

      commit(types.LOGIN_FAILURE, 'Oops! Something\'s wrong.');
    });
}

export function logout({ commit }) {
  localStorage.clear();
  commit(types.LOGOUT);
  commit(types.CLEAR_USERS);
}

export function getUsers({ commit }, { page, search } = {}) {
  commit(types.GET_USERS);

  api.get('/users', { params: { page, search } })
    .then(res => res.data)
    .then((data) => commit(types.GET_USERS_SUCCESS, data))
    .catch(() => commit(types.GET_USERS_FAILURE, 'Oops! Something\'s wrong.'));
}

export function clearUsers({ commit }) {
  commit(types.CLEAR_USERS);
}
