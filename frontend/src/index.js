import React from 'react';
import ReactDOM from 'react-dom';
import {HashRouter, Route, Switch, Redirect} from 'react-router-dom';
import {setTokenHeader} from './services/api/RestServices';

// Styles
// Import Font Awesome Icons Set
import 'font-awesome/css/font-awesome.min.css';
// Import Simple Line Icons Set
import 'simple-line-icons/css/simple-line-icons.css';
// Import Main styles for this application
import '../scss/style.scss'
// Temp fix for reactstrap
import '../scss/core/_dropdown-menu-right.scss'

// Containers
import Full from './containers/Full/'

// Views
import Login from './views/Pages/Login/'
import Register from './views/Pages/Register/'
import Page404 from './views/Pages/Page404/'
import Page500 from './views/Pages/Page500/'

function isLoggedIn(){
    var jwtToken = localStorage.getItem("jwtToken");
    if (!jwtToken) {
        return false;
    }

    setTokenHeader(jwtToken);
    return true;        
}

ReactDOM.render((
  <HashRouter>
    <Switch>
      <Route exact path="/login" name="Login Page" component={Login}/>
      <Route exact path="/register" name="Register Page" component={Register}/>
      <Route exact path="/404" name="Page 404" component={Page404}/>
      <Route exact path="/500" name="Page 500" component={Page500}/>
      <Route path="/home" name="Home" render={() => (isLoggedIn() ? (<Full/>): (<Redirect to="/login"/>))}/>
      <Redirect from="/" to="/login"/>
    </Switch>
  </HashRouter>
), document.getElementById('root'));
