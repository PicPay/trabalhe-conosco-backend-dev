import { Link } from 'react-router-dom';
import { connect } from 'react-redux';
import React from 'react';

import PaginationComponent from './PaginationTab';
import { NavHeaderBar, List } from '../_components';
import { searchActions } from '../_actions';

import axios from "axios";

class HomePage extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      input: '',
      data: null,
      isLoading: false,
      users: [],
      collapsed: true,
      page: 0,
      pageSize: 10,
      pagesCount: 0
    };

    this.toggleNavbar = this.toggleNavbar.bind(this);
  }

  toggleNavbar() {
    this.setState({
      collapsed: !this.state.collapsed
    });
  }

  onSearch(input) {
    this.updateSearch(input.target.value, 0);
  }

  onPaginatedSearch = (e) => {
    this.updateSearch(this.state.input, e - 1);
  }

  updateSearch(input,page=0) {
    const isLoading = true;
    this.setState( {input: input} );
    const URL = 'http://localhost:7700/api/user?text='+input+'&page='+page;
    if (input) {
     var config = {
            headers: {'Authorization':  localStorage.getItem( "token" )}
          };
      return axios.get(URL,config)
      .then( users => {
          this.setState( {
            data: users.data,
            users : users.data.content,
            isLoading: false,
            pagesCount: users.data.totalElements,
            page: page
          } );
      })
      .catch( err => {
            this.setState( {
               isLoading: false
             } );
      });
    }
  }
    render() {
        const { users,input, page, data,pagesCount,pageSize } = this.state;
        return (
            <React.Fragment>
                <NavHeaderBar />
                <div className="row bg-light">
                    <div className="col-sm-4 col-md-4">
                        <div class="form-group">
                            <div className="right-inner-addon ">
                                <i className="glyphicon glyphicon-search"></i>
                                <input type="text" id="input" placeholder="search..." className="form-control"
                                ref={node => this.input = node}  onChange={this.onSearch.bind(this)} />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div className="col-sm-8 col-md-8">
                        { pagesCount > 0&&this.state.input!=='' ?
                            <List
                                users={this.state.users}
                                isLoading={this.state.isLoading}
                                page={this.state.page}
                                onPaginatedSearch={this.onPaginatedSearch}
                                />
                            : null
                        }
                    </div>
                    <div className="col-md-6 col-md-offset-3">
                        { pagesCount > 0&&this.state.input!=='' ?
                            <PaginationComponent
                                totalItems={pagesCount}
                                pageSize={pageSize}
                                activePage={page}
                                onSelect={this.onPaginatedSearch}
                            />
                            : null
                        }
                    </div>
                </div>
            </React.Fragment>
        );
    }
}

function mapStateToProps(state) {
const { users, input } = state;
return {
users, input
};
}

const connectedHomePage = connect(mapStateToProps)(HomePage);
export { connectedHomePage as HomePage };