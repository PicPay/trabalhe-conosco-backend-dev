import React, { Component } from 'react';
import './SearchBox.css';

export default class SearchBox extends Component {
    constructor(props){
        super(props)
        this.state = {
            field : ''
        }
        this.handleField = this.handleField.bind(this);
    }

    handleField(event){
        this.setState({field: event.target.value});
    }

    render() {
    return (
      <div class="se">
        <div class="se-content">
            <div class="se-input">
                <label for="inp" class="inp">
                    <input type="text" id="inp" value={this.state.field} onChange={this.handleField} placeholder="&nbsp;" />
                    <span class="label">Search</span>
                    <span class="border"></span>
                </label>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                </tr>
                <tr>
                    <td></td>
                    <td>teste</td>
                    <td>test</td>
                </tr>
            </table>
        </div>
      </div>
    );
  }
}