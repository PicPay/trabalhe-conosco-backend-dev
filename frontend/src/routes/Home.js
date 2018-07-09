import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core';
import SearchBar from 'material-ui-search-bar';
import SearchResult from '../components/SearchResult';

import SearchService from '../shared/SearchService';

const styles = (theme) => ({
  root: {
    marginTop: theme.spacing.unit * 2
  },
  tableContainer: {
    marginTop: theme.spacing.unit * 2
  },
  searchbar: {
    margin: '0 auto',
    maxWidth: 800
  }
});

class Home extends Component {
  constructor(props) {
    super(props);
    this.state = {
      search: {
        term: undefined,
        pageSize: 15
      },
      searchResult: {
        isLoaded: false,
        content: [],
        searchMetadata: {},
        error: undefined,
        errorResponse: {}
      },
    };
    this.searchService = new SearchService();

    this.handleRequestSearch = this.handleRequestSearch.bind(this);
    this.handleChangePage = this.handleChangePage.bind(this);
    this.handleSearchChange = this.handleSearchChange.bind(this);
  }

  handleSearchChange(newTerm) {
    this.setState((prevState) => {
      let newSearch = {...prevState.search};
      newSearch.term = newTerm;
      return {search: newSearch};
    });
  }

  handleRequestSearch() {
    this.search();
  }

  handleChangePage(event, newPage) {
    const currentPage = (this.state.searchResult
      && this.state.searchResult.searchMetadata
      && this.state.searchResult.searchMetadata.page) || 1;
    const forward = (newPage > currentPage);
    if (forward) {
      this.searchNavigation('next');
    } else {
      this.searchNavigation('prev');
    }
  }

  search() {
    const { term } = this.state.search;
    if (!term) {
      return;
    }
    this.searchService.search(term)
      .then(searchResult => {
        this.setState({searchResult: {isLoaded: true, ...searchResult}});
      }).catch(errorResponse => {
        this.setState({searchResult: {isLoaded: true,error: true, ...errorResponse}});
      });
  }

  searchNavigation(direction) {
    const { term } = this.state.search;
    const { navRef } = this.state.searchResult.searchMetadata;
    this.searchService.search(term, direction, navRef)
      .then(searchResult => {
        this.setState({searchResult: {isLoaded: true, ...searchResult}});
      }).catch(errorResponse => {
        this.setState({searchResult: {isLoaded: true,error: true, ...errorResponse}});
      });
  }

  render() {
    const { classes } = this.props;
    return (
      <div className={classes.root}>
        <SearchBar className={classes.searchbar}
          value={this.state.search.term}
          onChange={this.handleSearchChange}
          onRequestSearch={this.handleRequestSearch}
        />
        <div className={classes.tableContainer}>
          <SearchResult 
            searchResult={this.state.searchResult}
            onChangePage={this.handleChangePage} />
        </div>
      </div>
    );
  }
}

Home.propTypes = {
  classes: PropTypes.object.isRequired
};

export default withStyles(styles)(Home);