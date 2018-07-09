import React from 'react';
import PropTypes from 'prop-types';
import { Route, HashRouter } from  'react-router-dom';
import { withStyles } from '@material-ui/core';
import Grid from '@material-ui/core/Grid';
import MenuApp from './components/MenuApp';
import Settings from './components/Settings';
import Home from './routes/Home';

const styles = {
  root: {
    flexGrow: 1
  }
};

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      open: false
    };
    this.handleClickSettings = this.handleClickSettings.bind(this);
    this.handleCloseSettings = this.handleCloseSettings.bind(this);
  }

  handleClickSettings() {
    this.setState({
      open: true
    });
  }

  handleCloseSettings() {
    this.setState({
      open: false
    });
  }

  render() {
    const { classes } = this.props;
    return (
      <HashRouter>
        <div className={classes.root}>
          <MenuApp onClickSettings={this.handleClickSettings} />
          <Grid container spacing={24}>
            <Grid item xs={12}>
              <Route exact path="/" component={Home} />
            </Grid>
          </Grid>
          <Settings openDialog={this.state.open} onClose={this.handleCloseSettings} />
        </div>
      </HashRouter>
    );
  }
}

App.propTypes = {
  classes: PropTypes.object.isRequired
};

export default withStyles(styles)(App);
