import React from 'react';
import { withStyles } from '@material-ui/core/styles';
import PropTypes from 'prop-types';
import AppBar from '@material-ui/core/AppBar';
import ToolBar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import Settings from '@material-ui/icons/Settings';

const styles = {
  root: {
    flexGrow: 1,
  },
  flex: {
    flex: 1,
  }
};

const MenuApp = (props) => {
  const { classes } = props;
  return (
    <div className={classes.root}>
      <AppBar position="static">
        <ToolBar>
          <Typography variant="title" color="inherit" className={classes.flex}>
            PicPay challenge frontend
          </Typography>
          <IconButton color="inherit" onClick={props.onClickSettings}>
            <Settings/>
          </IconButton>
        </ToolBar>
      </AppBar>
    </div>
  );
};

MenuApp.propTypes = {
  classes: PropTypes.object.isRequired,
  onClickSettings: PropTypes.func
};

export default  withStyles(styles)(MenuApp);
