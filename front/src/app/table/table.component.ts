import { Component, OnInit, OnDestroy } from '@angular/core';
import { DataService } from '../services/data.service'
import {Subject} from 'rxjs/Subject';
import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/distinctUntilChanged';

@Component({
  selector: 'app-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.css']
})
export class TableComponent implements OnInit {
  
  reg:Register[];
  count:number;

  private searchUpdate$: Subject<string> = new Subject<string>();
  private searchUpdateSubscriber$: any;
  loading = false;

  constructor(private dataService:DataService) { }

  ngOnInit() {
    this.count = 0;
    this.updateSearch();
    this.searchUpdateSubscriber$ = this.searchUpdate$
      .asObservable()
      .debounceTime(200)
      .subscribe(val => this.updateSearch(val));
  }

  ngOnDestroy() {
    this.searchUpdateSubscriber$.unsubscribe();
  }


  onSearch(value: string) {
    this.searchUpdate$.next(value);
    this.loading = true;
  }

  private updateSearch(value = undefined) {
    console.log('value', value);
    this.dataService.getRegisters(value).subscribe(registers => {
      this.reg = registers.data;
      console.log(this.reg);
      this.loading = false;
    },err=>{
      console.log(err);
      this.loading = false;
    });
  }

}
interface Register{
  uuid: string,
  name: string,
  username: string
}
