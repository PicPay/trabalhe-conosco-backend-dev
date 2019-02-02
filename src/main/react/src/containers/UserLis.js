import React, { Component } from 'react';
import { connect } from 'react-redux';

import { searchUsersAction} from '../actions/userActions';

import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import ListItemAvatar from '@material-ui/core/ListItemAvatar';
import Avatar from '@material-ui/core/Avatar';
import Typography from '@material-ui/core/Typography';
import { withStyles } from '@material-ui/core';
import deepPurple from '@material-ui/core/colors/deepPurple';
import Icon from '@material-ui/core/Icon';
import Button from '@material-ui/core/Button';

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
  
  componentDidMount(){
    this.props.dispatch(searchUsersAction('', this.props.user.page, this.props.user.size))    
  }
  
  handleIncreasePage = () => {
    if(this.props.user.page <= this.props.user.totalPages){
      this.props.dispatch(searchUsersAction(this.props.user.text, this.props.user.page + 1, this.props.user.size))
    }
  }

  handleDecreasePage = () => {
    if(this.props.user.page > 0){
      this.props.dispatch(searchUsersAction(this.props.user.text, this.props.user.page - 1, this.props.user.size))
    }
  }

  render(){               
    const { user, classes } = this.props;
    return( 
      <div>
        <div style={{display:'flex', paddingBottom: '4px', justifyContent:'flex-end'}}>
          <Typography style={{color: 'white', fontWeight: '600', fontSize: '15px', display:'flex', alignItems: 'center'}}>
            {((user.page*user.size)+1).toString().toLocaleString()}{" - "}{((user.page+1)*user.size).toString().toLocaleString()}{" of "}{user.totalElements.toLocaleString()}
          </Typography>
          <Button disabled={this.props.user.page <= 0} style={{marginLeft: '7px', backgroundColor: 'white'}} variant="contained" color="default" className={classes.button} onClick={this.handleDecreasePage}>          
            <Icon className={classes.rightIcon}>keyboard_arrow_left</Icon>
          </Button>
          <Button disabled={this.props.user.page > this.props.user.totalPages} style={{marginLeft: '7px', backgroundColor: 'white'}} variant="contained" color="default" className={classes.button} onClick={this.handleIncreasePage}>          
            <Icon className={classes.rightIcon}>keyboard_arrow_right</Icon>
          </Button>          
        </div>
         <List  style={{minHeight: '842px'}} className={classes.root}>        
         {  
           user.users.map(user => 
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

const mapStateToProps = ({user}) => ({
  user
});

export default connect(mapStateToProps)(withStyles(styles)(UserList));