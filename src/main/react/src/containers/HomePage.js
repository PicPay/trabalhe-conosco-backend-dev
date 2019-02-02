
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Redirect } from 'react-router-dom';

import UserList from './UserLis';
import SearchAppBar from './SearchAppBar';
import MessageSnackbar from './MessageSnackbar';

class HomePage extends Component {

    constructor(props) {
        super(props);
        this.state = {
            name: '',
        }
    }

    componentDidMount() {
        let data = JSON.parse(sessionStorage.getItem('userData'));
        if (data) {
            this.setState({ name: data.name })
        }
    }

    render() {
        const user = JSON.parse(sessionStorage.getItem('userData'));
        if (!user || (user && !user.name) || this.state.redirect) {
            return (<Redirect to={'/'} />)
        }

        return (
            <div style={{display: 'flex', flexDirection: 'column'}}>
                <MessageSnackbar />
                <SearchAppBar />
                <div style={{marginTop: '50px', marginLeft: '70px',  marginRight: '90px', padding: '20px', height: '100%'}}>
                    <UserList />
                </div>
            </div>            
        )
    }
}

export default connect()(HomePage);