import {Component, OnInit, Input} from '@angular/core';


@Component({
  selector: 'jcrop-fields',
  template: `
    
    <jcrop-field *ngFor="let field of fields" [field]="field" [storeId]="storeId"></jcrop-field> 
    
  `,
  styles: []
})
export class FieldsComponent implements OnInit {

  fields = ['x', 'y', 'x2', 'y2'];

  @Input() storeId: string;

  constructor() {
  }

  ngOnInit() {
  }

}
