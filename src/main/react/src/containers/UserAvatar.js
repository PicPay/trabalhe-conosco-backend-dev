import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles';
import Avatar from '@material-ui/core/Avatar';
import MenuItem from '@material-ui/core/MenuItem';
import Menu from '@material-ui/core/Menu';
import {Redirect} from 'react-router-dom';

const styles = {
  avatar: {
    margin: 10,
  },
  bigAvatar: {
    margin: 10,
    width: 60,
    height: 60,
  },
};

class UserAvatar extends React.Component {
    
    constructor(props){
      super(props);
      this.state = {
        anchorEl: null,
      }
    }

    handleMenu = event => {
      this.setState({ anchorEl: event.currentTarget });
    };
    handleClose = () => {
      this.setState({ anchorEl: null });
    };

    handleLogout = () => {
      this.setState({ anchorEl: null });
      sessionStorage.setItem("userData", null);
    }

    render(){
      const open = Boolean(this.state.anchorEl);
      const { classes } = this.props;  
      const user = JSON.parse(sessionStorage.getItem("userData"));
      
      if(user && user.name){        
          return (   
              <div> 
              <Avatar alt={user.name}  onClick={this.handleMenu} src={user.provider_pic} className={classes.avatar} />        
                <Menu
                  style={{width: '400px', height: '250px'}}
                  anchorEl={this.state.anchorEl}
                  anchorOrigin={{
                    vertical: 'top',
                    horizontal: 'right',
                  }}
                  transformOrigin={{
                    vertical: 'top',
                    horizontal: 'right',
                  }}
                  open={open}
                  onClose={this.handleClose}
                >
                <MenuItem onClick={this.handleLogout}>Sair</MenuItem>                
              </Menu>
              </div>
          );
      } else return (<Redirect to={'/'}/>)
    }
  
}

UserAvatar.propTypes = {
  classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(UserAvatar);
