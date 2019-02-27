import React, { Component } from 'react';
import './App.css';
import Headers from './Header'
import SearchBox from './SearchBox';

class App extends Component {
  constructor(props){
    super(props);
    this.state = {
      db : 8
    }
    this.dbCheck = this.dbCheck.bind(this);
  }

  dbCheck(){
    fetch('http://localhost:3100/dbstatus', {
      crossDomain: true,
      method: 'GET',
      headers: {'Content-type': 'application/json'}
    })
    .then((response) => {
      return response.json()})
    .then((reponseJson) => {
      let status = parseInt(reponseJson.status);
      console.log(status);
      this.setState({
        db: status
      });
    }).catch(() => 
      {
        this.setState({
          db: 8
        });
      }
    )
  }

  componentDidMount(){
    var db = setInterval((event) => {
      this.dbCheck();
    }, 1000);
  }

  render() {
    return (
      <section className="app">
        <Headers db={this.state.db} />
        <SearchBox db={this.state.db} />
      </section>
    );
  }
}

export default App;
