import React, { Component } from 'react';
import './Auth.css';
import InputText from './InputText';

export default class Auth extends Component {
    constructor(props){
        super(props);
        this.state = ({
            email: "",
            pass: ""
        })
        this.inputEmailHandle = this.inputEmailHandle.bind(this);
        this.inputPassHandle = this.inputPassHandle.bind(this);
        this.inputUriHandle = this.inputUriHandle.bind(this);
        this.inputHandleEnter = this.inputHandleEnter.bind(this);
        this.handleButtonClick = this.handleButtonClick.bind(this);
    }

    inputEmailHandle(event){
        this.setState({email: event.target.value});
    }

    inputPassHandle(event){
        this.setState({pass: event.target.value});
    }

    inputUriHandle(event){
        this.props.changeUri(event.target.value);
    }

    inputHandleEnter(event){
        if(event.keyCode == 13){
            this.requestAuth();
        }
    }

    handleButtonClick(){
        this.requestAuth();
    }

    requestAuth(){
        this.props.handleAuth(this.state.email, this.state.pass);
    }
    
    render() {
        return (
            <div className="auth-global">
                <div className="auth-container">
                    <div className="auth-inputContainer">
                        <InputText label="Username" handleInput={this.inputEmailHandle} value={this.state.email} handleEnter={this.inputHandleEnter}/>
                        <br />
                        <br />
                        <br />
                        <InputText label="Password" handleInput={this.inputPassHandle} value={this.state.pass} handleEnter={this.inputHandleEnter}/>
                        <br />
                        <br />
                        <br />
                        <InputText label="Server URL" handleInput={this.inputUriHandle} value={this.props.uri} handleEnter={this.inputHandleEnter}/>
                    </div>
                    <button className="auth-button" onClick={this.handleButtonClick}>Login</button>
                </div>
            </div>
        );
    }
}