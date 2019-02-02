import React, { Component } from 'react';
import SearchBar from 'material-ui-search-bar'
import { searchUsersAction } from '../actions/userActions';
import { connect } from 'react-redux';

class UserSearchBar extends Component {
  
    state = {
        value: ''
    }

    handleChange = (newValue) => {    
        this.setState({value : newValue})
        if(newValue !== ""){
            this.props.dispatch(searchUsersAction(newValue, this.props.user.page, this.props.user.size));
        } else {
            this.props.dispatch(searchUsersAction('', this.props.user.page, this.props.user.pagination));
        }
    }

    render(){
        return(      
            <SearchBar
            style={{height: '40px', width: '400px'}}
            value={this.state.value}   
            onChange={this.handleChange}
            onRequestSearch={() => this.state.value !== "" ? 
                this.props.dispatch(searchUsersAction(this.state.value, this.props.user.page, this.props.user.size)) :
                    this.props.dispatch(searchUsersAction('', this.props.user.page, this.props.user.size))}
            /> 
        )
    }
}


const mapStateToProps = ({user}) => ({
    user
});

export default connect(mapStateToProps)(UserSearchBar);

