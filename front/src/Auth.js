import React, { Component } from 'react';
import './Auth.css';
import InputText from './InputText';

export default class Auth extends Component {
    constructor(props){
        super(props);
        this.inputEmailHandle = this.inputEmailHandle.bind(this);
        this.inputPassHandle = this.inputPassHandle.bind(this);
        this.inputUriHandle = this.inputUriHandle.bind(this);
        this.inputHandleEnter = this.inputHandleEnter.bind(this);
        this.handleButtonClick = this.handleButtonClick.bind(this);
    }

    inputEmailHandle(event){
        this.props.changeEmail(event.target.value);
    }

    inputPassHandle(event){
        this.props.changePass(event.target.value);
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
        if(this.props.doing === 0)
            this.props.handleAuth();
    }
    
    render() {
        let buttonLabel = "Wait"
        if(this.props.doing === 0){
            buttonLabel = "Login"
        }
        return (
            <div className="auth-global">
                <div className="auth-container">
                    <div className="auth-inputContainer">
                        <InputText label="Email" type='text' handleInput={this.inputEmailHandle} value={this.props.email} handleEnter={this.inputHandleEnter}/>
                        <br />
                        <br />
                        <br />
                        <InputText label="Password" type="password" handleInput={this.inputPassHandle} value={this.props.pass} handleEnter={this.inputHandleEnter}/>
                        <br />
                        <br />
                        <br />
                        <InputText label="REST API URL" type='text' handleInput={this.inputUriHandle} value={this.props.uri} handleEnter={this.inputHandleEnter}/>
                    </div>
                    <button className="auth-button" onClick={this.handleButtonClick}>{buttonLabel}</button>
                </div>
            </div>
        );
    }
}