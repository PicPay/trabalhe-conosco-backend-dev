import axios from "axios";
import base64 from "base-64";
import utf8 from "utf8";

import config from 'config';
import { authHeader } from '../_helpers';

export const searchService = {
    search
};

  function search (input, page=0) {

    const URL = 'http://localhost:8080/api/user?text='+input+'&page='+page;

     var config = {
            headers: {'Authorization':  localStorage.getItem( "token" )}
          };

     return axios.get(URL,config)
      .then( users => {
         console.log(users);
      })
     // .catch( //err => {

      //       )
      //});

  } ;