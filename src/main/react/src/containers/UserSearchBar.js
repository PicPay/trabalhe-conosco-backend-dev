import React, { Component } from 'react';
import SearchBar from 'material-ui-search-bar'
import { searchUsersAction, getUsersAction } from '../actions/userActions';
import { connect } from 'react-redux';

class UserSearchBar extends Component {
  
    state = {
        value: ''
    }

    handleChange = (newValue) => {    
        this.setState({value : newValue})
        if(newValue !== ""){
            this.props.dispatch(searchUsersAction(newValue));
        } else {
            this.props.dispatch(getUsersAction());
        }
    }

    render(){
        return(      
            <SearchBar
            style={{height: '50px', width: '400px'}}
            value={this.state.value}   
            onChange={this.handleChange}
            onRequestSearch={() => this.state.value !== "" ? this.props.dispatch(searchUsersAction(this.state.value)) : this.props.dispatch(getUsersAction())}
            /> 
        )
    }
}

export default connect()(UserSearchBar);

