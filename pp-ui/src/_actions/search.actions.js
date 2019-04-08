import axios from "axios";
import base64 from "base-64";
import utf8 from "utf8";

import { history } from '../_helpers';
import { userConstants } from '../_constants';
import { searchService } from '../_services';
import { alertActions } from './';

export const searchActions = {
    search
};

export function search(name) {
     searchService.search(name)
        .then((response) => {
          dispatch(response)
        },
         error => {
            failure(error);
            alertActions.error(error);
            dispatch(failure(error));
        })
  }