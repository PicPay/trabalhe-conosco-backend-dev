import React, { Component } from 'react';
import './InputText.css';

export default class InputText extends Component {
    render() {
        return (
            <label htmlFor="inp" className="it-inp">
                <input type={this.props.type} className="it-input" id="inp" value={this.props.value} onChange={this.props.handleInput} onKeyDown={this.props.handleEnter} placeholder="&nbsp;" />
                <span className="it-label">{this.props.label}</span>
                <span className="it-border"></span>
            </label>
        )
    }
}