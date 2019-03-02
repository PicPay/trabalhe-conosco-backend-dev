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
      serverURI: "http://192.168.99.100:3100/"
    }
    this.dbCheck = this.dbCheck.bind(this);
    this.handleChangeUri = this.handleChangeUri.bind(this)
    this.handleAuth = this.handleAuth.bind(this);
  }

  dbCheck() {
    if(this.state.token == null) return;
    fetch(this.state.serverURI+'dbstatus', {
      crossDomain: true,
      method: 'GET',
      headers: { 'Content-type': 'application/json' }
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

  handleAuth(email, pass){
    var data = new FormData();
    data.append("client_id", 2);
    data.append("client_secret", 'U8Bvu2RPtxkuA3dU7sLkrCQ4ASK8jGrZaJOlPLLy');
    data.append("grant_type", 'password');
    data.append("username", "picpay@picpay.com");
    data.append("password", "admin");
    data.append("scope", "");
    fetch(this.state.serverURI+'oauth/token', {
      crossDomain: true,
      method: 'POST',
      headers: {'accept': 'application/json', "Access-Control-Allow-Origin": "*"},
      body: data
    })
  }

  componentDidMount() {
    var db = setInterval((event) => {
      this.dbCheck();
    }, 1000);
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
        <SearchBox db={this.state.db} serverURI={this.state.serverURI}/>
      </section>
    }else{
      renderObject = <Auth handleAuth={this.handleAuth} uri={this.state.serverURI} changeUri={this.handleChangeUri} />;
    }
    return (
      renderObject
    );
  }
}

export default App;
