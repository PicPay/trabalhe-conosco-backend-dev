'use strict';

const React = require('react');
const ReactDOM = require('react-dom');
const client = require('./client');

const follow = require('./follow'); // function to hop multiple links by "rel"

const profileURL = 'http://localhost:8086/api/profile/users';
const root = '/api/users/search';
const loadURL = 'usersbyname';

class App extends React.Component {

	constructor(props) {
		super(props);
		this.state = {users: [], attributes: [], pageSize: 20, nameSearch: 'bruno', links: {}};
		this.updatePageSize = this.updatePageSize.bind(this);
		this.updateNameSearch = this.updateNameSearch.bind(this);
		this.onNavigate = this.onNavigate.bind(this);
	}

	// tag::follow-2[]
	loadFromServer(pageSize, nameSearch) {
		console.log("loadFromServer pageSize "+pageSize+" nameSearch "+nameSearch);
		follow(client, root, [
			{rel: loadURL, params: {size: pageSize, name: nameSearch, username: nameSearch}}]
        ).then(userCollection => {
			return client({
				method: 'GET',
				path: profileURL,
				headers: {'Accept': 'application/schema+json'}
			}).then(schema => {
				this.schema = schema.entity;
				return userCollection;
			});
		}).done(userCollection => {
			this.setState({
				users: userCollection.entity._embedded.users,
				attributes: Object.keys(this.schema.properties),
				pageSize: pageSize,
				nameSearch: nameSearch,
				links: userCollection.entity._links});
		});
	}
	// end::follow-2[]

	// tag::navigate[]
	onNavigate(navUri) {
		client({method: 'GET', path: navUri}).done(userCollection => {
			this.setState({
				users: userCollection.entity._embedded.users,
				attributes: this.state.attributes,
				pageSize: this.state.pageSize,
				nameSearch: this.state.nameSearch,
				links: userCollection.entity._links
			});
		});
	}
	// end::navigate[]

	// tag::update-page-size[]
	updatePageSize(pageSize) {
		if (pageSize !== this.state.pageSize) {
			this.loadFromServer(pageSize, this.state.nameSearch);
		}
	}
	// end::update-page-size[]

	// tag::update-search-name[]
	updateNameSearch(nameSearch) {
	    console.log("updateNameSearch"+nameSearch);
		if (nameSearch !== this.state.nameSearch) {
			this.loadFromServer(this.state.pageSize, nameSearch);
		}
	}
	// end::update-search-name[]

	// tag::follow-1[]
	componentDidMount() {
	    console.log("componentDidMount pageSize "+this.state.pageSize+" nameSearch "+this.state.nameSearch);
		this.loadFromServer(this.state.pageSize, this.state.nameSearch);
	}
	// end::follow-1[]

	render() {
		return (
			<div>
				<UserList users={this.state.users}
							  links={this.state.links}
							  pageSize={this.state.pageSize}
							  nameSearch={this.state.nameSearch}
							  onNavigate={this.onNavigate}
							  updatePageSize={this.updatePageSize}
							  updateNameSearch={this.updateNameSearch}/>
			</div>
		)
	}
}

class UserList extends React.Component {

	constructor(props) {
		super(props);
		this.handleNavFirst = this.handleNavFirst.bind(this);
		this.handleNavPrev = this.handleNavPrev.bind(this);
		this.handleNavNext = this.handleNavNext.bind(this);
		this.handleNavLast = this.handleNavLast.bind(this);
		this.handlePageSize = this.handlePageSize.bind(this);
		this.handleNameSearch = this.handleNameSearch.bind(this);
	}

	// tag::handle-page-size-updates[]
	handlePageSize(e) {
		e.preventDefault();
		const pageSize = ReactDOM.findDOMNode(this.refs.pageSize).value;
		if (/^[0-9]+$/.test(pageSize)) {
			this.props.updatePageSize(pageSize);
		} else {
			ReactDOM.findDOMNode(this.refs.pageSize).value =
				pageSize.substring(0, pageSize.length - 1);
		}
	}
	// end::handle-page-size-updates[]

	// tag::handle-name-search-updates[]
	handleNameSearch(e) {
		e.preventDefault();
		const nameSearch = ReactDOM.findDOMNode(this.refs.nameSearch).value;
		if (/^[a-zA-Z ]+$/.test(nameSearch)) {
			this.props.updateNameSearch(nameSearch);
		} else {
			ReactDOM.findDOMNode(this.refs.nameSearch).value =
				nameSearch.substring(0, nameSearch.length - 1);
		}
	}
	// end::handle-name-search-updates[]

	// tag::handle-nav[]
	handleNavFirst(e){
		e.preventDefault();
		this.props.onNavigate(this.props.links.first.href);
	}

	handleNavPrev(e) {
		e.preventDefault();
		this.props.onNavigate(this.props.links.prev.href);
	}

	handleNavNext(e) {
		e.preventDefault();
		this.props.onNavigate(this.props.links.next.href);
	}

	handleNavLast(e) {
		e.preventDefault();
		this.props.onNavigate(this.props.links.last.href);
	}
	// end::handle-nav[]

	// tag::user-list-render[]
	render() {
		const users = this.props.users.map(user =>
			<User key={user._links.self.href} user={user} />
		);

		const navLinks = [];
		if ("first" in this.props.links) {
			navLinks.push(<button key="first" onClick={this.handleNavFirst}>&lt;&lt;</button>);
		}
		if ("prev" in this.props.links) {
			navLinks.push(<button key="prev" onClick={this.handleNavPrev}>&lt;</button>);
		}
		if ("next" in this.props.links) {
			navLinks.push(<button key="next" onClick={this.handleNavNext}>&gt;</button>);
		}
		if ("last" in this.props.links) {
			navLinks.push(<button key="last" onClick={this.handleNavLast}>&gt;&gt;</button>);
		}

		return (
			<div>
                <p key="nameSearch">
                    Nome: <input type="text" placeholder="nameSearch" ref="nameSearch" className="field" defaultValue={this.props.nameSearch} onInput={this.handleNameSearch}/>
                </p>
                <p key="pageSize">
                    Tamanho página: <input type="text" placeholder="pageSize" ref="pageSize" className="field" defaultValue={this.props.pageSize} onInput={this.handlePageSize}/>
                </p>
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
				<div>
					{navLinks}
				</div>
			</div>
		)
	}
	// end::user-list-render[]
}

// tag::user[]
class User extends React.Component {

	constructor(props) {
		super(props);
	}

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

ReactDOM.render(
	<App />,
	document.getElementById('react')
)
