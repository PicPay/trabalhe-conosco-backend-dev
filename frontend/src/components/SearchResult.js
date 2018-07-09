import React from 'react';
import PropTypes from 'prop-types';
import { withStyles, TableFooter, TablePagination } from '@material-ui/core';
import Table from '@material-ui/core/Table';
import TableHead from '@material-ui/core/TableHead';
import TableBody from '@material-ui/core/TableBody';
import TableRow from '@material-ui/core/TableRow';
import CustomTableCell from './CustomTableCell';
import SearchResultContent from './SearchResultContent';
import NoContentSearchResult from './NoContentSearchResult';

const styles = (theme) => ({
  table: {
  },
  row: {
    '&:nth-of-type(odd)': {
      backgroundColor: theme.palette.background.default,
    }
  }
});

const SearchResult = (props) => {
  const { classes } = props;
  let bodyContent;
  let footerContent = null;
  if (!props.searchResult.isLoaded) {
    bodyContent = <NoContentSearchResult className={classes.row} text="Informe o nome do usuário ou o username" />;
  } else if (props.searchResult.error) {
    bodyContent = <NoContentSearchResult className={classes.row} text="Ocorreu um erro durante a pesquisa. Verifique as configurações... :-(" />;
  } else if (!props.searchResult.content || !props.searchResult.content.length) {
    bodyContent = <NoContentSearchResult className={classes.row} text="Nenhum resultado foi encontrado" />;
  } else {
    bodyContent = <SearchResultContent className={classes.row} content={props.searchResult.content} />;
    footerContent = (
      <TableFooter>
        <TableRow>
          <TablePagination
            page={(props.searchResult.searchMetadata.page || 1) - 1} //zero-based
            rowsPerPage={props.searchResult.searchMetadata.pageSize || 0}
            count={props.searchResult.searchMetadata.totalElements || 0}
            onChangePage={(event, page) => props.onChangePage(event, (page + 1))} //Soma + 1 a pagina, pois o número das páginas são zero-based
            rowsPerPageOptions={[]}
            backIconButtonProps={{
              'aria-label': 'Página anterior',
            }}
            nextIconButtonProps={{
              'aria-label': 'Próxima página',
            }} />
        </TableRow>
      </TableFooter>
    );
  }
  const idColumnStyle = {width: '265px'};
  return (
    <Table className={classes.table}>
      <TableHead>
        <TableRow>
          <CustomTableCell style={idColumnStyle}>Id</CustomTableCell>
          <CustomTableCell>Nome</CustomTableCell>
          <CustomTableCell>Username</CustomTableCell>
        </TableRow>
      </TableHead>
      <TableBody>
        {bodyContent}
      </TableBody>
      {footerContent}
    </Table>
  );
};

SearchResult.propTypes = {
  classes: PropTypes.object.isRequired,
  searchResult: PropTypes.object.isRequired,
  onChangePage: PropTypes.func.isRequired
};

export default withStyles(styles)(SearchResult);