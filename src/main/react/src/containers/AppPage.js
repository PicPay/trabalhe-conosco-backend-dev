
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Redirect } from 'react-router-dom';

import UserPage from './UserPage';
import MiniDrawer from './MiniDrawer';

class AppPage extends Component {

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
            <MiniDrawer>
                <UserPage />
            </MiniDrawer>
        )
    }
}

const mapStateToProps = () => ({

});

export default connect(mapStateToProps)(AppPage);