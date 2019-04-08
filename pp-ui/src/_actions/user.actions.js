import axios from "axios";
import base64 from "base-64";
import utf8 from "utf8";

import { userConstants } from '../_constants';
import { userService } from '../_services';
import { alertActions } from './';
import { history } from '../_helpers';

export const userActions = {
    doLogin,
    doLogout,
    isAuthenticated,
    getAll
};

export function isAuthenticated() {
  return function(dispatch) {
     let url =  'http://localhost:7700/user/dauanda.bonnard'
     var config = {
      headers: {'Authorization':  localStorage.getItem( "token" )}
    };
     axios.get(url, config)
        .then((response) => {
          dispatch({type: "IS_AUTHENTICATED", payload: response.data})
        })
        .catch((err) => {
          dispatch({type: "IS_NOT_AUTHENTICATED", payload: ''})
        })
    }
}

export function doLogin(username, password) {
  if(username && password) {
    return function(dispatch) {
     userService.login(username, password)
        .then((user) => {
          localStorage.removeItem( "token" )
          localStorage.setItem( "token", user.data.token );
          dispatch(success(user))
          history.push('/');
        },
         error => {
            failure(error);
            alertActions.error(error);
            dispatch(failure(error));
        })
    }
  }
  return {
    type: "LOGIN_EMPTY",
    payload: {
      message : "Empty username or password.",
    }
  };

    function request(user) { return { type: userConstants.LOGIN_REQUEST, user } }
    function success(user) { return { type: userConstants.LOGIN_SUCCESS, user } }
    function failure(error) { return { type: userConstants.LOGIN_FAILURE, error } }
}

export function doLogout() {
    userService.logout();
  return {
    type: userConstants.LOGOUT,
    payload: ''
  }
}

export function getAll() {
   return dispatch => {
        dispatch(request());
            userService.getAll()
        .then(user => {
            dispatch(success(user))
         },
         error => {
            dispatch(failure(error))
     })
   }
   function request() { return { type: userConstants.GETALL_REQUEST } }
   function success(user) { return { type: userConstants.GETALL_SUCCESS, user } }
   function failure(error) { return { type: userConstants.GETALL_FAILURE, error } }
}