import React, {Component} from "react";
import {
Badge,
        Button,
        Row,
        Col,
        Card,
        CardHeader,
        CardBlock,
        Table,
        Pagination,
        PaginationItem,
        PaginationLink,
        Input,
        InputGroup,
        InputGroupAddon,
        InputGroupButton
        } from "reactstrap";
import AlertContainer from 'react-alert';
import ReactTable from "react-table";
import "react-table/react-table.css";
import {search} from '../../../services/api/RestServices';

class Tables extends Component {
    constructor(props) {
        super(props);
        this.state = {
            data: [],
            loading: false,
            q: '',
            firstSearchDone: false
        };

        this.handleInputChange = this.handleInputChange.bind(this);
        this.performSearch = this.performSearch.bind(this);
        this.callServiceSearch = this.callServiceSearch.bind(this);
        this.fetchData = this.fetchData.bind(this);
    }

    handleInputChange(event) {
        const target = event.target;

        this.setState({
            [target.name]: target.value
        });
    }
    
    callServiceSearch(parameters) {
        this.setState({ loading: true });
        
        search(parameters).then((response) => {
            this.setState({ data: response.data });
            this.setState({ loading: false });
        }).catch((error) => {
            if (error.response.data.status === 401) {
                this.props.history.push('/login');
                return;
            }
            
            this.msg.error("Well, this is awkward. Looks like something went wrong. Please try again.");
            this.setState({ loading: false });
        });
    }
    
    fetchData(parameters) {
        var pageSize = parameters ? parameters.pageSize : 15;
        var page = parameters ? parameters.page : 0;

        var param = { q: this.state.q,
            pageSize: pageSize,
            page: page };
        
        this.callServiceSearch(param);
    }

    performSearch(event) {
        event.preventDefault();

        if (!this.state.firstSearchDone) {
            this.setState({ firstSearchDone: true });
            return;
        }

        var param = { q: this.state.q };

        this.callServiceSearch(param);
    }

    render() {
        let columns = [{ Header: "ID", accessor: "id" },
            { Header: "Name", accessor: "name" },
            { Header: "Username", accessor: "username" },
            { Header: "Weight", accessor: "weight" }]

        return (
            <div className="animated fadeIn">
                <AlertContainer ref={a => this.msg = a} />
                <Row>
                    <Col md="12">
                    <Card>
                    <CardBlock className="card-body">
                        <form onSubmit={(event) => this.performSearch(event)}>
                            <InputGroup>
                                <Input type="text" id="input1-group2" name="q" value={this.state.q} onChange={this.handleInputChange} placeholder="Enter a keyword to search..." required/>
                                <InputGroupButton>
                                    <Button color="primary" type="submit"><i className="fa fa-search"></i>Search</Button>
                                </InputGroupButton>
                            </InputGroup>
                        </form>
                        <br/>
                        { this.state.firstSearchDone ? <ReactTable
                            columns={columns}
                            manual
                            data={this.state.data.content}
                            pages={this.state.data.totalPages}
                            loading={this.state.loading}
                            onFetchData={this.fetchData}
                            defaultPageSize={15}
                            sortable={false}
                            pageSizeOptions={[5, 10, 15, 20, 25, 50, 100]}
                            className="-striped -highlight"/> : null
                        }
                    </CardBlock>
                    </Card>
                    </Col>
                </Row>
            </div>
        );
    }
}

export default Tables;