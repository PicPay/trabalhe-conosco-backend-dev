
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { GoogleLogin } from 'react-google-login';
import {Redirect} from 'react-router-dom';
import googleCredentials from '../constants/credentials-react.json';

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
            //if(userData.email.includes("@guiabolso.com.br")){
                sessionStorage.setItem("userData", JSON.stringify(userData));
                this.setState({redirect: true});
            // } else {
            //     this.setState({loginError: true});
            // }            
        }
    }

    onSignInFailure = (response) => {
        console.log(response);
        this.setState({loginError: true});
    }

    render(){ 
        const userData = sessionStorage.getItem('userData')
        if (this.state.redirect || (userData && userData.name)) {            
            return (<Redirect to={'/home'}/>)
        }

        return (<div className="container">
            <div className="row">
                <div className="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div className="card card-signin my-5">
                        <div className="card-body">
                            <div style={{marginBottom:'10px',display:'flex',alignItems:'center',justifyContent:'center'}}>
                                <img alt="" style={{width:'170px'}} src="/logo.png" />
                            </div>
                            <h1 style={{marginTop: '30px'}}className="card-title text-center">Ofertas de Crédito</h1>
                            <div style={{display:'flex',justifyContent: 'center', marginTop: '50px', marginBottom: '30px', alignItems: 'center'}}>
                                <GoogleLogin
                                    clientId={googleCredentials.web.client_id}
                                    buttonText={!userData || (userData && !userData.name) ? "Entrar" : "Sair"}
                                    onSuccess={this.onSignInSuccess}
                                    onFailure={this.onSignInFailure}
                                />
                            </div>
                            <div style={{color: 'red', textAlign: 'center'}}>{this.state.loginError ? "Usuário ou senha inválida!" : null}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>)
    }
}

export default connect()(LoginPage);