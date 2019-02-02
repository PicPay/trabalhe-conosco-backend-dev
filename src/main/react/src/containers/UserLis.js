import React, { Component } from 'react';
import { connect } from 'react-redux';

import { getUsersAction } from '../actions/userActions';

import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import ListItemAvatar from '@material-ui/core/ListItemAvatar';
import Avatar from '@material-ui/core/Avatar';
import Typography from '@material-ui/core/Typography';
import { withStyles } from '@material-ui/core';
import deepPurple from '@material-ui/core/colors/deepPurple';

const styles = theme => ({
  root: {
    width: '100%',    
    overflow: 'auto',
    backgroundColor: theme.palette.background.paper,
  },
  inline: {
    display: 'inline',
  },
  purpleAvatar: {    
    color: '#fff',
    backgroundColor: deepPurple[500],
  },
});

class UserList extends Component {
  
  state = {
    open: false
  }

  componentDidMount(){
    this.props.dispatch(getUsersAction())    
  }
  
  render(){               
    const { users, classes } = this.props;
    return( 
      <div>
         <List component="nav" className={classes.root}>        
         {  
           users.map(user => 
             <ListItem key={user.id} style={{paddingTop:'3px'}} alignItems="flex-start" button>
                <ListItemAvatar>
                  <Avatar className={classes.purpleAvatar}>{user.name[0]}</Avatar>
                </ListItemAvatar>
                <ListItemText
                  primary={user.name}
                  secondary={
                    <React.Fragment>
                      <Typography component="span" className={classes.inline} color="textSecondary">
                        {user.userName}
                      </Typography>                      
                    </React.Fragment>
                  }
                />
              </ListItem>
            )
         }
        </List>
      </div>)
  }
}

const mapStateToProps = ({users, filter}) => ({
  users,
  filter
});

export default connect(mapStateToProps)(withStyles(styles)(UserList));