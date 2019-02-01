import ReactDOM from 'react-dom';
import React from 'react';
import { Provider } from 'react-redux';
import { BrowserRouter, Route, Switch } from 'react-router-dom'

import configureStore from './stores/configureStores';
import LoginPage from './containers/LoginPage';
import AppPage from './containers/AppPage';

import './styles/style.css';

const store = configureStore();

ReactDOM.render(
  <Provider store={store}>          
    <BrowserRouter>        
          <Switch>              
              <Route path="/home" component={AppPage}/>
              <Route path="/" component={LoginPage} />
          </Switch>        
    </BrowserRouter>        
  </Provider>, document.getElementById('root')
);