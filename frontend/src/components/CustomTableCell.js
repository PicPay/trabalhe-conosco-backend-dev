import { withStyles } from '@material-ui/core';
import TableCell from '@material-ui/core/TableCell';

const CustomTableCell = withStyles(theme => ({
  head: {
    backgroundColor: theme.palette.primary.light,
    color: theme.palette.common.white
  },
  body: {
    fontSize: 14
  }
}))(TableCell);

export default CustomTableCell;