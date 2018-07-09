import AppSettings from './AppSettings';

class SearchService {

  /**
   * Realiza uma pesquisa no indice de usuários
   * @param term Termo a ser pesquisa
   * @param direction Direção da navegação. next ou prev
   * @param navRef Referência para navegação entre os resultados da pesquisa
   * @param pageSize Quantidade de registros por página
   */
  search(term, direction='next', navRef=null, pageSize=15) {
    let url = `${AppSettings.backendUrl}users/search`;
    const headers = new Headers();
    headers.append('Authorization', 'ApiKey ' + AppSettings.apiKey);
    headers.append('Content-Type', 'application/json');

    const body = {
      q: term,
      direction: direction,
      navRef: navRef,
      pageSize: pageSize
    };

    return fetch(url, {
      method: 'POST',
      body: JSON.stringify(body),
      headers: headers
    }).then(response => {
      if (response.status === 200) {
        return Promise.resolve(response.json());
      } else {
        return Promise.reject(response.json());
      }
    });
  }

}

export default SearchService;
