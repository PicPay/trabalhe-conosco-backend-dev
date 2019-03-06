import {Injectable, ApplicationRef} from '@angular/core';
import {Observable, Subject, Subscription} from "rxjs/Rx";
import {config} from '../smartadmin.config';
import {languages} from './languages.model';
import {JsonApiService} from "../../core/api/json-api.service";



@Injectable()
export class I18nService {

  public state;
  public data:{};
  public currentLanguage:any;


  constructor(private jsonApiService:JsonApiService, private ref:ApplicationRef) {
    this.state = new Subject();

    this.initLanguage(config.defaultLocale || 'us');
    this.fetch(this.currentLanguage.key)
  }

  private fetch(locale: any) {
    this.jsonApiService.fetch( `/langs/${locale}.json` )
      .subscribe((data:any)=> {
        this.data = data;
        this.state.next(data);
        this.ref.tick()
      })
  }

  private initLanguage(locale:string) {
    let language = languages.find((it)=> {
      return it.key == locale
    });
    if (language) {
      this.currentLanguage = language
    } else {
      throw new Error(`Incorrect locale used for I18nService: ${locale}`);

    }
  }

  setLanguage(language){
    this.currentLanguage = language;
    this.fetch(language.key)
  }


  subscribe(sub:any, err:any) {
    return this.state.subscribe(sub, err)
  }

  public getTranslation(phrase:string):string {
    return this.data && this.data[phrase] ? this.data[phrase] : phrase
  }

}
