import React from 'react';
import { Route, Redirect } from 'react-router-dom';

import utf8 from "utf8";
import decode from 'decode-html';

export const List = ({ users, page, isLoading, onPaginatedSearch }) => (
  <React.Fragment>
    { users ?
      <table className="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Uuid</th>
            <th>Name</th>
            <th>Username</th>
          </tr>
        </thead>
        <tbody>
      {users && users.map(user =>
        <tr key={user.uuid}>
          <th scope="row"></th>
          <td>{user.uuid}</td>
          <td>{utf8.encode(user.name)}</td>
          <td>{decode(user.username)}</td>
        </tr>
      )}
      </tbody>
    </table>
    :
    <table className="table">
        <thead>
            <tr>
                <th>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Não foram encontrados resultados!</td>
            </tr>
        </tbody>
    </table>
    }
  </React.Fragment>
  )