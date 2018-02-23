import React, {Component} from 'react';
import {
  Badge,
  Dropdown,
  DropdownMenu,
  DropdownItem,
  Nav,
  NavItem,
  NavLink,
  NavbarToggler,
  NavbarBrand,
  DropdownToggle
} from 'reactstrap';
import {logout} from '../../services/api/RestServices';
import {withRouter} from "react-router-dom";

class Header extends Component {
    constructor(props) {
        super(props);

        this.toggle = this.toggle.bind(this);
        this.callLogout = this.callLogout.bind(this);

        this.state = {
            dropdownOpen: false,
            username: localStorage.getItem("username")
        };    
    }
  
    callLogout(){
        logout();
        this.props.history.push("/login");
    }

  toggle() {
    this.setState({
      dropdownOpen: !this.state.dropdownOpen
    });
  }

  render() {
    return (
      <header className="app-header navbar">
        <NavbarBrand href="#"></NavbarBrand>
        <Nav className="ml-auto" navbar style={{ padding: '0.5rem 1rem'}}>
          <NavItem>
            <Dropdown isOpen={this.state.dropdownOpen} toggle={this.toggle}>
              <DropdownToggle className="nav-link dropdown-toggle">
                <span className="d-md-down-none">Hi, {this.state.username}</span>
              </DropdownToggle>
              <DropdownMenu right className={this.state.dropdownOpen ? 'show' : ''}>
                <DropdownItem onClick={this.callLogout}><i className="fa fa-lock"></i> Logout</DropdownItem>
              </DropdownMenu>
            </Dropdown>
          </NavItem>
        </Nav>
      </header>
    )
  }
}

export default withRouter(Header);
