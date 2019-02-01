import React, { Component } from 'react';
import { connect } from 'react-redux';

import { getUsersAction } from '../actions/userActions';
import UserSearchBar from './UserSearchBar';

class UserPage extends Component {
  
  state = {
    open: false
  }

  componentDidMount(){
    this.props.dispatch(getUsersAction())    
  }
  
  render(){               
    const { users } = this.props;
    return( 
      <div>        

        <div style={{backgroundColor: 'white', display: 'flex', height: '70px', flexDirection: 'row', justifyContent: 'flex-start'}}>  
          <div style={{flexGrow: '1', display: 'flex', flexDirection: 'row', justifyContent: 'bottom'}}>
            <div style={{width: '100%', flexDirection: 'column', alignSelf: 'center'}}><UserSearchBar /></div>
          </div>          
        </div>

        <div style={{color: 'white', paddingTop: '5px', display: 'flex', flowDirection: 'row', justifyContent: 'flex-start'}}>            
          <div style={{flexGrow: '1', display: 'flex', flowDirection: 'row', justifyContent: "flex-end", marginBottom: '50px'}}></div>          
        </div>                
        
      </div>)
  }
}

const mapStateToProps = ({users, filter}) => ({
  users,
  filter
});

export default connect(mapStateToProps)(UserPage);