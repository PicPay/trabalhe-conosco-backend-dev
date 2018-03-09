import {Injectable} from '@angular/core';
import {ListResult} from '../models/list-result.interface';

@Injectable()
export class PaginationService {

  public queryParams: any[];
  public queryExclusion: string[] = ['deep', 'perpage'];

  getPager(totalItems: number, pageSize: number = 10): {} {

    let currentPage: number = this.getParam('page');
    currentPage = currentPage ? currentPage : 1;
    const totalPages = Math.ceil(totalItems / pageSize);
    const pages = [];
    const maxNavigationLinks = 5;

    for (let i = currentPage - maxNavigationLinks; i <= currentPage - 1; i++) {
      if (i > 0) {
        pages.push(i);
      }
    }

    pages.push(+currentPage);

    for (let i = +currentPage + 1; i <= +currentPage + maxNavigationLinks; i++) {
      if (i < +totalPages) {
        pages.push(i);
      }
    }

    return {
      totalItems: totalItems,
      currentPage: currentPage,
      totalPages: totalPages,
      pages: pages
    };
  }


  handleQueryParams(params: any): any[] {

    const finalParams: any[] = [];

    Object.keys(params).forEach(function (key) {
      finalParams.push({[key]: params[key]});
    });

    if (!(Object.keys(params).some(function (item) {
        return item === 'page';
      }))) {
      finalParams.push({'page': 1});
    }

    this.queryParams = finalParams;

    return this.queryParams;
  }

  getParam(param: string) {

    let data: any = null;

    this.queryParams.forEach(function (item: {}) {
      Object.keys(item).forEach(function (key) {
        if (key === param) {
          data = item[key];
        }
      });
    });

    return data;
  }

  buildRouterQueryParams(list: ListResult<any>, queryExclusion: string[] = null, action: string = null, page: number = null): {} {

    action = action == null ? 'first' : action;

    const urlQueryParams: string[] = (list._links[(action)].split('?')[1]).split('&');
    let objectParamsStr = '{ ';

    queryExclusion = queryExclusion != null ? queryExclusion.concat(['deep']) : this.queryExclusion;

    urlQueryParams.forEach(function (value) {
      const valueSplit = value.split('=');
      const param: string = valueSplit[0];
      let paramValue: any = valueSplit[1];

      if (!(queryExclusion.some(function (item) {
          return item == param;
        }))) {

        if (page != null && param == 'page') {
          paramValue = page;
        }

        objectParamsStr += '"' + param + '"' + ' : ' + '"' + paramValue + '"' + ', ';
      }
    });

    objectParamsStr = objectParamsStr.substr(0, (objectParamsStr.length - 2)) + ' }';

    return JSON.parse(objectParamsStr);
  }

}
