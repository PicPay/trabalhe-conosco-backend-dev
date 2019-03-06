import {
  Component, OnInit, ElementRef, Input, AfterContentInit, OnChanges,
  SimpleChanges
} from '@angular/core';

declare var $: any;

@Component({

  selector: 'sa-flot-chart',
  template: `
    <div class="sa-flot-chart" [ngStyle]="{width: width, height: height}">&nbsp;</div>
  `,
  styles: [`
  .sa-flot-chart{
    overflow: hidden;
  }
`]
})
export class FlotChartComponent implements AfterContentInit, OnChanges {

  @Input() public data:any;
  @Input() public graphClass: string= '';
  @Input() public options:any;
  @Input() public type:string;
  @Input() width:string = '100%';
  @Input() height:string = '250px';

  private vendorLoaded = false;

  constructor(private el: ElementRef) {}

  ngAfterContentInit() {
    System.import('imports-loader?this=>window!smartadmin-plugins/flot-bundle/flot-bundle.min.js').then(()=>{
      this.vendorLoaded = true;
      this.render(this.data)
    });
  }

  render(data){
    if(data){
      $.plot(this.el.nativeElement.children[0], data, this.options)
    }
  }

 ngOnChanges(changes){
    if(this.vendorLoaded && changes.data.currentValue){
      this.render(changes.data.currentValue)
    }
  }





}
