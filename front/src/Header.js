import React, { Component } from 'react';
import './Header.css';

export default class Header extends Component {
  render() {
      let db = this.props.db;
      let dbStatus = "none";
      let dbStatusColor;
      if(db === 0){
        dbStatus = "Not Ready";
        dbStatusColor = 'white';
      }else if(db === 1){
          dbStatus = "Importing";
          dbStatusColor = 'white'
      }else if(db === 2){
          dbStatus = "Ready";
          dbStatusColor = "white";
      }else{
        dbStatusColor = "red";
          dbStatus = "Unknown";
      }
      const dbStatusStyle = {
          color: dbStatusColor,
          fontWeigth: 'bolder'
      };
    return (
      <header className="header">
        <div className="header-logo">
            Teste PicPay BackEnd
        </div>
        <div className="header-info">
            ElasticSearch Status: <span style={dbStatusStyle}>{dbStatus}</span>
        </div>
      </header>
    );
  }
}