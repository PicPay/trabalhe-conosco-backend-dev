import {Component, OnInit, Input} from '@angular/core';
import {CropActions} from "../actions/crop.actions";
import {NgRedux} from "@angular-redux/store";
import {Observable} from "rxjs";

@Component({
  selector: 'jcrop-field',
  template: `
    <div>
        <input type="number" id="{{id}}"                                              
               #input
               [value]="value$ | async"
               (change)="actions.cropFieldChange(field, input.value, storeId)"/>
        <label htmlFor="{{id}}" class="active">{{field}}</label>
    </div>
  `,
  styles: []
})
export class FieldComponent implements OnInit {


  value$: Observable<any>

  public id:string;

  @Input() field: string;
  @Input() storeId: string;

  static idCounter = 0;

  constructor(public actions: CropActions, private ngRedux: NgRedux<any>) {
    this.id = 'jcrop-field-' + FieldComponent.idCounter++
  }

  ngOnInit() {
    this.value$ = this.ngRedux.select([this.storeId, 'crop', 'selection', this.field]);
  }


}
