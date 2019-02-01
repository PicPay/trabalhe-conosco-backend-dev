import React from 'react';
import PropTypes from 'prop-types';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';

class AlertDialog extends React.Component {
 
  handleClose = () => {
    this.props.onClose(false);
  };

  handleOk = () => {
      this.props.onClose(false);
      this.props.onSubmit();
  }

  render() {
    return (
      <div>        
        <Dialog
          open={this.props.open}
          onClose={this.handleClose}
          aria-labelledby="alert-dialog-title"
          aria-describedby="alert-dialog-description"
        >
          <DialogTitle id="alert-dialog-title">
            {this.props.title}
          </DialogTitle>
          <DialogContent>
            <DialogContentText id="alert-dialog-description">
              {this.props.text}
            </DialogContentText>
          </DialogContent>
          <DialogActions>
            <Button onClick={this.handleClose} color="primary">
              {this.props.cancelLabel}
            </Button>
            <Button onClick={this.handleOk} color="primary" autoFocus>
              {this.props.submitLabel}
            </Button>
          </DialogActions>
        </Dialog>
      </div>
    );
  }
}

AlertDialog.propTypes = {
    open: PropTypes.bool,
    text: PropTypes.string,
    title: PropTypes.string,
    onClose: PropTypes.func,
    onSubmit: PropTypes.func,
    cancelLabel: PropTypes.string,
    submitLabel: PropTypes.string
}

export default AlertDialog;
