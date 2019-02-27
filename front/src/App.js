import React, { Component } from 'react';
import './App.css';
import Headers from './Header'

class App extends Component {
  constructor(props){
    super(props);
    this.state = {
      db : 0
    }
  }

  dbCheck(){
    return;
  }

  render() {
    return (
      <section class="app">
        <Headers db={this.state.db} />
      </section>
    );
  }
}

export default App;
