import React, { Component } from 'react';
import PropTypes from 'prop-types';

class PaginationComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            activePage: this.props.activePage,
            firstPaginationNumber: 1
        }
        this.pages = this.getNumberOfPages(this.props);
    }

    componentWillReceiveProps(props) {
        this.pages = this.getNumberOfPages(props);
        this.forceUpdate();
    }

    getNumberOfPages = (props) => {
        const auxPages = props.totalItems / props.pageSize;
        let pages = parseInt(auxPages, 10);
        pages += pages !== auxPages ? 1 : 0;
        return pages;
    }

    paginationItems = () => {
        let items = [];
        this.lastPaginationNumber = this.getLastPaginationNumber();
        items.push(this.firstOrLastPagItem("<<", 1));
        items.push(this.nextOrPreviousPagItem("<", 1, 'l'));
        for (var i = this.state.firstPaginationNumber; i <= this.lastPaginationNumber; i++) {
            items.push(this.numberedPagItem(i));
        }
        items.push(this.nextOrPreviousPagItem(">", this.pages, 'r'));
        items.push(this.firstOrLastPagItem(">>", this.pages));
        return items;
    }

    getLastPaginationNumber = () => {
        const minNumberPages = Math.min(this.pages, this.props.maxPaginationNumbers);
        return this.state.firstPaginationNumber + minNumberPages - 1;
    }

    numberedPagItem = (i) => {
        return (
            <li className={this.state.activePage === i ? 'page-item active' : 'page-item'} key={i} id={`pagebutton${i}`} onClick={this.handleClick}>
                <a className="page-link" style={{ minWidth: '43.5px' }}>
                    {i}
                </a>
            </li>
        )
    }

    nextOrPreviousPagItem = (name, page, direction) => {
        return (
            <li className={this.state.activePage === page ? 'page-item disabled' : 'page-item' } key={name} onClick={(e) => this.handleSelectNextOrPrevious(direction)}>
                <a className="page-link" >
                    {name}
                </a>
            </li>
        )
    }

    firstOrLastPagItem = (name, page) => {
        let event = {
            currentTarget: {
                getAttribute: () => `pagebutton${page}`
            }
        }
        return (
            <li className={this.state.activePage === page ? 'page-item disabled' : 'page-item' } key={name} onClick={() => this.handleClick(event)}>
                <a className="page-link">
                    {name}
                </a>
            </li>
        )
    }

    handleClick = (event) => {
        const newActivePage = parseInt(event.currentTarget.getAttribute("id").split("pagebutton").pop(), 10);
        this.setState({
            activePage: newActivePage
        })
        this.handlePaginationNumber(newActivePage);
        this.props.onSelect(newActivePage);
    }

    handleSelectNextOrPrevious = (direction) => {
        const activePage = this.state.activePage;
        if ((direction === 'r' && activePage === this.pages) || (direction === 'l' && activePage === 1))
            return;

        const newActivePage = direction === 'r' ? activePage + 1 : activePage - 1;

        this.setState({
            activePage: newActivePage
        })

        this.handlePaginationNumber(newActivePage);
        this.props.onSelect(newActivePage);
    }

    handlePaginationNumber = (activePage) => {
        const distance = Math.floor(this.props.maxPaginationNumbers / 2);
        const newFPNumber = activePage - distance;
        const newLPNumber = activePage + distance;
        if (newFPNumber <= distance) {
            if (this.state.firstPaginationNumber !== 1) {
                this.setState({
                    firstPaginationNumber: 1
                })
            }
        } else if (newLPNumber <= this.pages) {
            this.setState({
                firstPaginationNumber: newFPNumber
            })
        } else if (newLPNumber >= this.pages) {
            this.setState({
                firstPaginationNumber: this.pages - this.props.maxPaginationNumbers + 1
            })
        }
    }

    render() {
        return (
            <ul className="pagination">
                {this.paginationItems()}
            </ul>
        )
    }
}

PaginationComponent.propTypes = {
    totalItems: PropTypes.number.isRequired,
    pageSize: PropTypes.number.isRequired,
    onSelect: PropTypes.func.isRequired,
    maxPaginationNumbers: PropTypes.number,
    activePage: PropTypes.number
}

PaginationComponent.defaultProps = {
    maxPaginationNumbers: 5,
    activePage: 1
}

export default PaginationComponent;
