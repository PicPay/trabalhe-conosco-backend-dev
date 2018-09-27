'use strict';

// tag::vars[]
const React = require('react');
const ReactDOM = require('react-dom');
import Pagination from "react-js-pagination";
//require("bootstrap/less/bootstrap.less");


const client = require('./client');
//const dataGrid = require('react-data-grid');
// end::vars[]

// tag::app[]
class App extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
		    users: [],
		    activePage: 1,
		    itemPerPage: 15
		 };
	}

      handlePageChange(pageNumber) {
        console.log(`active page is ${pageNumber}`);
        this.setState({activePage: pageNumber});
      }

	componentDidMount() {
		client({method: 'GET', path: '/api/users?page'+this.state.activePage+'&size=15'}).done(response => {
			this.setState({users: response.entity._embedded.users});
		});
	}

	render() {
		return (
              <div>
                <div>
                    <UserList users={this.state.users}/>
                </div>
                <div>
                    <Pagination
                      activePage={this.state.activePage}
                      itemsCountPerPage={15}
                      totalItemsCount={1000}
                      pageRangeDisplayed={5}
                      onChange={this.handlePageChange.bind(this)}
                    />
                </div>
              </div>
		)
	}
}
// end::app[]

// tag::user-list[]
class UserList extends React.Component{
	render() {
		var users = this.props.users.map(user =>
			<User key={user._links.self.href} user={user}/>
		);
		return (
			<table>
				<tbody>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Username</th>
					</tr>
					{users}
				</tbody>
			</table>
		)
	}
}
// end::user-list[]

// tag::user[]
class User extends React.Component{
	render() {
		return (
			<tr>
				<td>{this.props.user.id}</td>
				<td>{this.props.user.name}</td>
				<td>{this.props.user.username}</td>
			</tr>
		)
	}
}
// end::user[]

// tag::render[]
ReactDOM.render(
	<App />,
	document.getElementById('react')
)
// end::render[]

