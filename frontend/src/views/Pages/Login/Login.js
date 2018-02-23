import React, {Component} from "react";
import {Container, Row, Col, CardGroup, Card, CardBlock, Button, Input, InputGroup, InputGroupAddon} from "reactstrap";
import {doLogin, setTokenHeader} from '../../../services/api/RestServices';
import AlertContainer from 'react-alert';


class Login extends Component {
    constructor(props) {
        super(props);
        this.state = {
            username: '',
            password: ''
        };

        this.handleInputChange = this.handleInputChange.bind(this);
        this.doLogin = this.doLogin.bind(this);
    }

    doLogin(event) {
        event.preventDefault();

        doLogin(this.state).then((response) => {
            setTokenHeader(response.data.token);

            localStorage.setItem('username', this.state.username);
            localStorage.setItem('jwtToken', response.data.token);

            this.props.history.push('/home');
        }).catch((error) => {
            this.msg.error('Signin failed. Please check your credentials.');
        });
    }
    
    handleInputChange(event) {
        const target = event.target;
        
        this.setState({
          [target.name]: target.value
        });
    }

    render() {
        return (
          <div className="app flex-row align-items-center">
            <AlertContainer ref={a => this.msg = a} />
            <Container>
              <Row className="justify-content-center">
                <Col md="8">
                  <CardGroup className="mb-0">
                    <Card className="p-4">
                      <CardBlock className="card-body">
                        <form onSubmit={(event) => this.doLogin(event)}>
                            <h1>Login</h1>
                            <p className="text-muted">Sign In to your account</p>
                            <InputGroup className="mb-3">
                              <InputGroupAddon><i className="icon-user"></i></InputGroupAddon>
                              <Input type="text" placeholder="Username" name='username' value={this.state.username} onChange={this.handleInputChange} required/>
                            </InputGroup>
                            <InputGroup className="mb-4">
                              <InputGroupAddon><i className="icon-lock"></i></InputGroupAddon>
                              <Input type="password" placeholder="Password" name='password' value={this.state.password} onChange={this.handleInputChange} required/>
                            </InputGroup>
                            <Row>
                              <Col xs="12">
                                <Button color="primary" type="submit" className="px-4">Login</Button>
                              </Col>
                            </Row>
                        </form>
                      </CardBlock>
                    </Card>
                    <Card className="text-white bg-primary py-5 d-md-down-none" style={{ width: 44 + '%' }}>
                      <CardBlock className="card-body text-center">
                        <div>
                          <h2>Sign up</h2>
                          <p>The challenge is to create a REST API that performs a search for users by name and username
                            given a keyword. Check it out.</p>
                          <Button color="primary" className="mt-3" href="#/register" active>Register Now!</Button>
                        </div>
                      </CardBlock>
                    </Card>
                  </CardGroup>
                </Col>
              </Row>
            </Container>
          </div>
        );
  }
}

export default Login;
