import { Injectable } from '@angular/core';
import { Http} from '@angular/http';
import 'rxjs/add/operator/map';
@Injectable()
export class DataService {

  constructor(public http:Http) { 
    console.log("dataserve");    
  }
  getRegisters(name = undefined, offset = 1){
    let params = {
      offset: offset
    };
    if(name) {
      params['name'] = name;
    }
    return this.http.get('http://node:3000/api/registers', {params: params})
    .map(res => res.json());
  }

}
