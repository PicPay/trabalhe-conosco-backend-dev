import React, { Component } from 'react';
import './App.css';
import Headers from './Header'
import SearchBox from './SearchBox';

class App extends Component {
  constructor(props){
    super(props);
    this.state = {
      db : 2
    }
  }

  dbCheck(){
    return;
  }

  render() {
    return (
      <section class="app">
        <Headers db={this.state.db} />
        <SearchBox />
      </section>
    );
  }
}

export default App;
