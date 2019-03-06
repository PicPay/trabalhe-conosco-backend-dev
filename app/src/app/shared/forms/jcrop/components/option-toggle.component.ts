import {Component, OnInit, Input} from '@angular/core';
import {OptionsActions} from "../actions/options.actions";
import {NgRedux} from "@angular-redux/store";

@Component({
  selector: 'jcrop-option-toggle',
  template: `
    <div class="switch">
        <label >
            <input type="checkbox" [checked]="active"
             [(ngModel)]="active" (ngModelChange)="onChange()" />
                <span class="lever" ></span>
            {{label}}
        </label>
    </div>
  `,
})
export class OptionToggleComponent implements OnInit {

  @Input() active: boolean;
  @Input() label: string;
  @Input() option: string;

  @Input() storeId: string;

  constructor(private ngRedux: NgRedux<any>, private actions: OptionsActions) { }

  ngOnInit() {
    let options = this.storeId? this.ngRedux.getState()[this.storeId].options : this.ngRedux.getState().options;

    if(options && options[this.option]){
      this.active = true
    }
  }

  onChange(){
    this.actions.toggleOption({
      option: this.option,
      storeId: this.storeId
    })
  }

}
