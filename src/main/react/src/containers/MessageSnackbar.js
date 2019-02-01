import React from 'react';
import PropTypes from 'prop-types';
import Snackbar from '@material-ui/core/Snackbar';
import { connect } from 'react-redux';
import SnackbarBody from '../components/SnackbarBody';
import { showMessage } from '../actions/messageActions';

class MessageSnackbar extends React.Component {
  
  handleClose = (event, reason) => {    
    this.props.dispatch(showMessage('',false,''));
  };

  render() {
    const hasSuccess = this.props.message && this.props.message.messageType === 'SUCCESS' ? true : false
    const hasFailure = this.props.message && this.props.message.messageType === 'FAILURE' ? true : false
    const hasInfo = this.props.message && this.props.message.messageType === 'INFO' ? true : false
    const hasWarning = this.props.message && this.props.message.messageType === 'WARNING' ? true : false
    if(!hasSuccess && !hasFailure && !hasInfo && !hasWarning) return <div></div>
    return (
      <div>         
        <Snackbar
          anchorOrigin={{vertical: 'top', horizontal: 'center'}}
          open={this.props.message.show}
          autoHideDuration={6000}
          onClose={this.handleClose}
        >
        {
          hasSuccess ? <SnackbarBody onClose={this.handleClose} variant="success" message={this.props.message.text}/> : 
            hasFailure ? <SnackbarBody onClose={this.handleClose} variant="error" message={this.props.message.text}/> :
              hasInfo ? <SnackbarBody onClose={this.handleClose} variant="info" message={this.props.message.text}/> :
                hasWarning ? <SnackbarBody onClose={this.handleClose} variant="warning" message={this.props.message.text}/> : null
        }
        </Snackbar>        
      </div>
    );
  }
}

MessageSnackbar.propTypes = {
  message: PropTypes.object
};

const mapStateToProps = ({message}) => ({
  message: message
});

export default MessageSnackbar = connect(mapStateToProps)(MessageSnackbar);
