import React, { Component } from 'react';
import './Header.css';

export default class Header extends Component {
  render() {
      let db = this.props.db;
      let dbStatus = "none";
      if(db == 0){
        dbStatus = "Not Ready";
      }else if(db == 1){
          dbStatus = "Importing";
      }else if(db == 2){
          dbStatus = "Ready";
      }else{
          dbStatus = "Unknown";
      }
    return (
      <header class="header">
        <div class="header-logo">
            Teste PicPay BackEnd
        </div>
        <div class="header-info">
            ElasticSearch Status: {dbStatus}
        </div>
      </header>
    );
  }
}