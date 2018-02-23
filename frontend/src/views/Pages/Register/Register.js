import React, {Component} from "react";
import {Container, Row, Col, Card, CardBlock, CardFooter, Button, Input, InputGroup, InputGroupAddon} from "reactstrap";
import {signup} from '../../../services/api/RestServices';
import AlertContainer from 'react-alert';

class Register extends Component {
  constructor(props) {
        super(props);
        this.state = {
          username: '',
          password: ''
        };

        this.handleInputChange = this.handleInputChange.bind(this);
        this.signup = this.signup.bind(this);
    }
    
    signup(event) {
        event.preventDefault();

        signup(this.state).then((response) => {
            this.msg.success("Success! You've joined PicPay Test.");
            setTimeout(() => {
                this.props.history.push('/login');
            }, 4000);            
        }).catch((error) => {
            this.msg.error("Well, this is awkward. Looks like something went wrong. Please try again.");
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
            <Col md="6">
              <Card className="mx-4">
                <CardBlock className="card-body p-4">
                  <form onSubmit={(event) => this.signup(event)}>
                    <h1>Register</h1>
                    <p className="text-muted">Create your account</p>
                    <InputGroup className="mb-3">
                      <InputGroupAddon><i className="icon-user"></i></InputGroupAddon>
                      <Input type="text" name="username" placeholder="Username" value={this.state.username} onChange={this.handleInputChange} minLength='6' required/>
                    </InputGroup>
                    <InputGroup className="mb-3">
                      <InputGroupAddon><i className="icon-lock"></i></InputGroupAddon>
                      <Input type="password" name="password" placeholder="Password" value={this.state.password} onChange={this.handleInputChange} minLength='6' required/>
                    </InputGroup>
                    <Button color="success" block type="submit">Create Account</Button>
                  </form>
                </CardBlock>
                <CardFooter className="p-1">
                  <Row>
                    <Col md="12">
                        <Button color="link" size="md" href="/#/login" block>Already have an account? Sign in.</Button>
                    </Col>
                  </Row>
                </CardFooter>
              </Card>
            </Col>
          </Row>
        </Container>
      </div>
    );
  }
}

export default Register;
