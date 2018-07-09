import React from 'react';
import PropTypes from 'prop-types';
import TableRow from '@material-ui/core/TableRow';
import CustomTableCell from './CustomTableCell';

const SearchResultContent = (props) => {
  return props.content.map(user => (
    <TableRow key={user.id} className={props.className}>
      <CustomTableCell>{user.id}</CustomTableCell>
      <CustomTableCell>{user.name}</CustomTableCell>
      <CustomTableCell>{user.username}</CustomTableCell>
    </TableRow>
  ));
};

SearchResultContent.propTypes = {
  className: PropTypes.string
};

export default SearchResultContent;