import React from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core';
import Dialog from '@material-ui/core/Dialog';
import DialogTitle from '@material-ui/core/DialogTitle';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogActions from '@material-ui/core/DialogActions';
import TextField from '@material-ui/core/TextField';
import Button from '@material-ui/core/Button';
import AppSettings from '../shared/AppSettings';

const styles = theme => ({
  textField: {
    marginLeft: theme.spacing.unit,
    marginRight: theme.spacing.unit
  }
});

class Settings extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      data: {
        backendUrl: AppSettings.backendUrl,
        apiKey: AppSettings.apiKey
      },
      cachedProps: {
        openDialog: false
      }
    };
    this.handleChange = this.handleChange.bind(this);
    this.handleClickCancel = this.handleClickCancel.bind(this);
    this.handleClickOk = this.handleClickOk.bind(this);
    this.handleCloseDialog = this.handleCloseDialog.bind(this);
    this.handleEnterDialog = this.handleEnterDialog.bind(this);
  }

  handleChange(name) {
    return event => {
      const value = event.target.value;
      this.setState(prevState => {
        let newData = {...prevState.data};
        newData[name] = value;
        return {data: newData};
      });
    };
  }

  handleClickOk() {
    const { backendUrl, apiKey } = this.state.data;
    if (backendUrl && apiKey) {
      AppSettings.backendUrl = backendUrl;
      AppSettings.apiKey = apiKey;

      this.handleCloseDialog();
    }
  }

  handleClickCancel() {
    this.handleCloseDialog();
  }

  handleCloseDialog(event) {
    this.props.onClose(event);
  }

  handleEnterDialog() {
    this.setState({
      data: {
        backendUrl: AppSettings.backendUrl,
        apiKey: AppSettings.apiKey
      }
    });
  }

  static getDerivedStateFromProps(nextProps, prevState) {
    const { openDialog: propOpenDialog } = nextProps;
    const { cachedProps } = prevState;
    if (propOpenDialog !== cachedProps.openDialog) {
      let newCachedProps = {...prevState.cachedProps};
      newCachedProps.openDialog = propOpenDialog;
      return {cachedProps: newCachedProps};
    }
    return null;
  }

  render() {
    const { classes } = this.props;
    return (
      <div>
        <Dialog aria-labelledby="form-dialog-title"
          disableBackdropClick={true}
          fullWidth={true}
          open={this.state.cachedProps.openDialog}
          onEnter={this.handleEnterDialog}
          onClose={this.handleCloseDialog}>
          <DialogTitle id="form-dialog-title">Configurações</DialogTitle>
          <DialogContent>
            <DialogContentText>
              Configurações para acesso ao backend
            </DialogContentText>
            <form autoComplete="off">
              <TextField id="backendUrl"
                label="URL do Backend"
                type="url"
                value={this.state.data.backendUrl}
                onChange={this.handleChange('backendUrl')}
                className={classes.textField}
                margin="dense"
                autoFocus
                fullWidth />
              <TextField id="apiKey"
                label="API Key"
                type="text"
                value={this.state.data.apiKey}
                onChange={this.handleChange('apiKey')}
                className={classes.textField}
                margin="dense"
                fullWidth />
            </form>
          </DialogContent>
          <DialogActions>
            <Button color="secondary" onClick={this.handleClickCancel}>Cancelar</Button>
            <Button color="primary" onClick={this.handleClickOk} >OK</Button>
          </DialogActions>
        </Dialog>
      </div>
    );
  }
}

Settings.propTypes = {
  classes: PropTypes.object.isRequired,
  openDialog: PropTypes.bool.isRequired,
  onClose: PropTypes.func
};

export default withStyles(styles)(Settings);