var React = require('react');
var DefaultLayout = require('./layouts/default');

class HelloMessage extends React.Component {
    render() {
        return (
            <DefaultLayout title={this.props.title} class="text-center">
                <form className="form-signin">
                    <img className="mb-4" src="images/bootstrap-solid.svg" alt="" width="72"
                         height="72"/>
                    <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>
                    <label htmlFor="inputEmail" className="sr-only">Email address</label>
                    <input type="text" id="inputEmail" className="form-control" placeholder="Email address"
                           required="" autoFocus="" autoComplete="off"/>
                    <label htmlFor="inputPassword" className="sr-only">Password</label>
                    <input type="password" id="inputPassword" className="form-control" placeholder="Password"
                           required="" autoComplete="off"
                    />

                    <div className="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"/> Remember me
                        </label>
                    </div>
                    <button className="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    <p className="mt-5 mb-3 text-muted">© 2017-2019</p>
                </form>
            </DefaultLayout>
        );
    }
}

module.exports = HelloMessage;