import {Component, OnInit, Input, ElementRef, HostListener, Output, EventEmitter} from '@angular/core';

declare var $: any;

@Component({
  selector: 'duallistbox',
  template: `
     <select multiple class="smart-duallistbox">
        <option *ngFor="let item of items" [selected]="item.selected" [value]="item.key">{{item.value}}</option>
      </select>
  `,
  styles: []
})
export class DuallistboxComponent implements OnInit {

  @Input() items: Array<any>;
  @Output() itemsChange = new EventEmitter();
  @Input() selected: Array<any> = [];

  @Input() nonSelectedFilter: any;
  @Input() nonSelectedListLabel: string = 'Non-selected';
  @Input() selectedListLabel: string = 'Selected';
  @Input() preserveSelectionOnMove: string = 'moved';
  @Input() moveOnSelect: boolean = false;
  @Input() size: number = 10;

  @HostListener('click') onClick(){
    let selected = this.element.find('.smart-duallistbox').val() || [];

    if (
      selected.some(it=>this.selected.indexOf(it) == -1)
      ||
      this.selected.some(it=>selected.indexOf(it) == -1)
    ){
      this.selected = selected;

      this.items.forEach((item)=>{
        if(this.selected.indexOf(item.key) > -1){
          item.selected = true
        } else {
          delete item.selected
        }
      });

      this.itemsChange.emit(this.items)
    }

  }

  private element: any;

  constructor(private el: ElementRef) {
    this.element = $(this.el.nativeElement);

  }

  ngOnInit() {
    this.selected = this.items.filter((item)=>item.selected).map(item=>item.key);
    System.import('script-loader!bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js').then(()=>{
      this.render()
    })
  }


  render(){

    let options = {
      nonSelectedFilter: this.nonSelectedFilter,
      nonSelectedListLabel: this.nonSelectedListLabel,
      selectedListLabel: this.selectedListLabel,
      preserveSelectionOnMove: this.preserveSelectionOnMove,
      moveOnSelect: this.moveOnSelect,
      size: this.size
    }

    this.element.bootstrapDualListbox(options);
  }

}
