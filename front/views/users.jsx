var React = require('react');
var DefaultLayout = require('./layouts/default');

class HelloMessage extends React.Component {
    render() {
        return (
            <DefaultLayout title={this.props.title} class="text-center">
               <form>
                <input type="text"/>
               </form>

                <table>
                    <th>
                        <td>Nome</td>
                        <td>Username</td>
                    </th>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </DefaultLayout>
        );
    }
}

module.exports = HelloMessage;