'use strict';

// tag::vars[]
const React = require('react');
const ReactDOM = require('react-dom');
const client = require('./client');
// end::vars[]

// tag::app[]
class App extends React.Component {

	constructor(props) {
		super(props);
		this.state = {users: []};
	}

	componentDidMount() {
		client({method: 'GET', path: '/api/users'}).done(response => {
			this.setState({users: response.entity._embedded.users});
		});
	}

	render() {
		return (
			<UserList users={this.state.users}/>
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

