import React from 'react';
import { Route, Redirect } from 'react-router-dom';

export const NavHeaderBar = () => (
        <nav className="navbar navbar-default">
          <div className="container-fluid">
            <div className="navbar-header">
              <a className="navbar-brand" href="#">Pick Search</a>
            </div>
            <ul className="nav navbar-nav">
              <li className="active"><a href="#">Home</a></li>
            </ul>
            <ul className="nav navbar-nav navbar-right">
              <li><a href="/login"><span className="glyphicon glyphicon-log-in"></span>  Logout</a></li>
            </ul>
          </div>
        </nav>
        )