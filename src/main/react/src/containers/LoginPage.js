
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { GoogleLogin } from 'react-google-login';
import {Redirect} from 'react-router-dom';
import googleCredentials from '../constants/credentials-dev.json';
import { validateUser } from '../Api/api';

class LoginPage extends Component {
 
    constructor(props){
        super(props);
        this.state = {
            loginError: false,
            redirect: false
        }
    }
    
    onSignInSuccess = (response) => {        
        if(response.w3.U3){            
            const userData = {
                name: response.w3.ig,
                email: response.w3.U3,
                provider_id: response.El,
                token: response.Zi.access_token,
                provider_pic: response.w3.Paa
            };
            validateUser(userData).then(response => {
                if(response.content.length > 0){
                    sessionStorage.setItem("userData", JSON.stringify(userData));
                    this.setState({redirect: true});            
                } else {
                    this.setState({loginError: true});
                }
            }).catch(error => {
                this.setState({loginError: true});                
            })            
        }
    }

    onSignInFailure = (response) => {
        console.log(response)
        this.setState({loginError: true});
    }

    render(){ 
        const userData = sessionStorage.getItem('userData')
        if (this.state.redirect || (userData && userData.name)) {            
            return (<Redirect to={'/home'}/>)
        }

        return (<div className="container">
            <div className="row">
                <div style={{marginTop: '100px'}} className="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div className="card my-5">
                        <div className="card-body">
                            <div style={{marginBottom:'10px',display:'flex',alignItems:'center',justifyContent:'center'}}>
                                <img alt="" style={{width:'400px'}} src="/picpay-extended.png" />
                            </div>                            
                            <div style={{display:'flex',justifyContent: 'center', marginTop: '10px', marginBottom: '50px', alignItems: 'center'}}>
                                <GoogleLogin                                    
                                    clientId={googleCredentials.web.client_id}
                                    theme="light"
                                    buttonText={!userData || (userData && !userData.name) ? "Sign in with Google" : "Sign out"}
                                    onSuccess={this.onSignInSuccess}
                                    onFailure={this.onSignInFailure}
                                />
                            </div>
                            <div style={{color: 'red', textAlign: 'center'}}>{this.state.loginError ? "You're not authorized to sign in." : null}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>)
    }
}

export default connect()(LoginPage);