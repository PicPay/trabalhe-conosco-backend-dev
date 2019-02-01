import React, { Component } from 'react';
import SearchBar from 'material-ui-search-bar'
import { searchText } from '../actions/filterActions';
import { connect } from 'react-redux';

class UserSearchBar extends Component {
  
    state = {
        value: ''
    }

    handleChange = (newValue) => {    
        this.setState({value : newValue})
        this.props.dispatch(searchText(newValue));
    }

    render(){
        return(      
            <SearchBar
            style={{height: '70px'}}
            value={this.state.value}   
            onChange={this.handleChange}        
            onRequestSearch={() => this.props.dispatch(searchText(this.state.value))}
            /> 
        )
    }
}

export default connect()(UserSearchBar);

