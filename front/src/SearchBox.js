import React, { Component } from 'react';
import './SearchBox.css';
import InputText from './InputText';

export default class SearchBox extends Component {
    constructor(props){
        super(props)
        this.state = {
            field : '',
            nResults: 0,
            results: [],
            pag: 1
        }
        this.handleField = this.handleField.bind(this);
        this.handleButton = this.handleButton.bind(this);
        this.handlePagButton = this.handlePagButton.bind(this);
        this.handleInputEnter = this.handleInputEnter.bind(this);
    }

    handleField(event){
        this.setState({field: event.target.value});
    }

    handleButton(){
        this.setState({
            pag: 1
        }, () => {
            this.search();
        });
    }

    search(){
        if(this.props.db != 2){
            alert("DB dont ready");
            return;
        }
        let keyword = this.state.field;
        let from = this.state.pag;
        let requestUri = this.props.serverURI+"users";
        if(keyword.length > 0){
            requestUri += "?name=" + keyword;
            requestUri += "&from=" + --from*15;
        }else{
            requestUri += "?from=" + --from*15;
        }
        fetch(requestUri, {
            crossDomain: true,
            method: 'GET',
            headers: {'Content-type': 'application/json',  'Accept' : 'application/json' ,'Authorization' : "Bearer "+this.props.token}
            })
            .then((response) => {
            return response.json()})
            .then((reponseJson) => {
                let nResults = reponseJson.header.total;
                let results = reponseJson.content;
                if(nResults === 0){
                    results = []
                }
                this.setState({
                    nResults: nResults,
                    results: results
                })
                console.log(this.state.results);
            }
        ).catch(() => {
            alert("Search Error")
        });
    }

    createTable(){
        let table = [];
        try{
            this.state.results.forEach(
                (item, indice) => {
                    table.push(
                        <tr key={item.id}>
                            <td>{item.id}</td>
                            <td>{item.name}</td>
                            <td>{item.username}</td>
                        </tr>
                    )
                }
            );
        }catch(Exception){

        }
        return table;
    }

    handleInputEnter(event){
        if(event.keyCode == 13){
            this.setState({
                pag:1
            }, () => {
                this.search();
            })
        }
    }

    handlePagButton(value){
        let pag = this.state.pag;
        pag += value;
        if(pag < 1){
            pag = 1;
        }
        if(this.state.nResults <= pag*15){
            return;
        }
        if(value == -2){
            pag = 1;
        }
        if(value == 2){
            pag = 665;
        }
        this.setState({
            pag:pag,
        }, () => {
            this.search();
        })
    }

    render() {
        let table = this.createTable();
        return (
        <div className="se">
            <div className="se-content">
                <div className="se-input">
                    <InputText handleInput={this.handleField} type='text' value={this.state.field} handleEnter={this.handleInputEnter} label="Search"/>
                    <button onClick={this.handleButton}>
                        Search
                    </button>
                </div>
                <div className="table">
                    <table>
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                            </tr>
                            {table}
                        </tbody>
                    </table>
                </div>
                <div className="rodape">
                    Number of results: {this.state.nResults}
                    <div className="pagination">
                        <button onClick={() => this.handlePagButton(-2)}>&lt;&lt;</button>
                        <button onClick={() => this.handlePagButton(-1)}>&lt;</button>
                        {this.state.pag}
                        <button onClick={() => this.handlePagButton(1)}>&gt;</button>
                        <button onClick={() => this.handlePagButton(2)}>&gt;&gt;</button>
                    </div>
                </div>
            </div>
        </div>
        );
  }
}