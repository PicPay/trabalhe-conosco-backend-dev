import React from 'react';
import PropTypes from 'prop-types';
import TableRow from '@material-ui/core/TableRow';
import CustomTableCell from './CustomTableCell';

const NoContentSearchResult = (props) => {
  return (
    <TableRow className={props.className}>
      <CustomTableCell colSpan={3}>{props.text}</CustomTableCell>
    </TableRow>
  );
};

NoContentSearchResult.propTypes = {
  className: PropTypes.string,
  text: PropTypes.string.isRequired
};

export default NoContentSearchResult;
