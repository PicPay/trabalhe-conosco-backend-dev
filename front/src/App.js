import React, { Component } from 'react';
import './App.css';
import Headers from './Header'
import SearchBox from './SearchBox';
import Auth from './Auth';

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      db: 8,
      nImports: 0,
      token: null,
      serverURI: "http://192.168.99.100:3100/",
      email: "picpay@picpay.com",
      pass: "admin"
    }
    this.dbCheck = this.dbCheck.bind(this);
    this.handleChangeUri = this.handleChangeUri.bind(this)
    this.handleAuth = this.handleAuth.bind(this);
    this.handleEmailField = this.handleEmailField.bind(this);
    this.handlePassField = this.handlePassField.bind(this);
  }

  dbCheck() {
    if(this.state.token == null) return;
    let token = this.state.token;
    fetch(this.state.serverURI+'dbstatus', {
      crossDomain: true,
      method: 'GET',
      headers: { 'Content-type': 'application/json', 'Accept' : 'application/json' ,'Authorization' : "Bearer "+token }
    })
      .then((response) => {
        return response.json()
      })
      .then((reponseJson) => {
        let status = parseInt(reponseJson.status);
        let n = 0;
        if (status == 1) {
          n = reponseJson.n;
        }
        this.setState({
          db: status,
          nImports: n
        });
      }).catch(() => {
        this.setState({
          db: 8
        });
      }
      )
  }

  handleAuth(){
    let data = new FormData();
    data.append("username",this.state.email);
    data.append("password", this.state.pass);
    fetch(this.state.serverURI+'login', {
      crossDomain: true,
      method: 'POST',
      headers: {},
      body: data
    })
    .then((response) => {
      return response.json();
    }).then((responseJson) => {
      let token = responseJson.success.token;
      this.setState({
        token: token
      })
    }).catch( () => {
      alert("Login error");
    })
  }

  handleEmailField(email){
    this.setState({
      email: email
    })
  }

  handlePassField(pass){
    this.setState({
      pass: pass
    })
  }

  componentDidMount() {
    var db = setInterval((event) => {
      this.dbCheck();
    }, 3000);
  }

  handleChangeUri(uri){
    this.setState({
      serverURI: uri
    })
  }

  render() {
    let renderObject
    if(this.state.token){
      renderObject = <section className="app">
        <Headers db={this.state.db} n={this.state.nImports} />
        <SearchBox db={this.state.db} token={this.state.token} serverURI={this.state.serverURI}/>
      </section>
    }else{
      renderObject = <Auth handleAuth={this.handleAuth} email={this.state.email} pass={this.state.pass} uri={this.state.serverURI} changeEmail={this.handleEmailField} changePass={this.handlePassField} changeUri={this.handleChangeUri} />;
    }
    return (
      renderObject
    );
  }
}

export default App;
