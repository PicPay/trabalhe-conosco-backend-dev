import {Component, OnInit, ElementRef, Input, AfterViewInit, ViewChild} from '@angular/core';

@Component({
  selector: 'sa-dygraph',
  template: `
    <div [ngStyle]="{width: width, height: height}" >
      dygraph canvas!
    </div>
    <div class="sa-dygraph-legend" #legend></div>
  `,
  styles: [`
    sa-dygraph{
      position: relative;
    }
    .sa-dygraph-legend{
      position: absolute;
      top: 0;
      right: 0;
      text-align: right;
    }
`]
})

export class DygraphComponent implements AfterViewInit, OnInit {

  @Input() options:any = {};
  @Input() data:any = {};
  @Input() width:string = '100%';
  @Input() height:string = '300px';

  @ViewChild('legend') legend: ElementRef;

  constructor(private el:ElementRef) {
  }

  ngOnInit() {
  }

  ngAfterViewInit() {
    // to improve latency for big components smartadmin app we are loading dependency async
    System.import('dygraphs/dist/dygraph.js').then((Dygraph)=> {
      new Dygraph(this.el.nativeElement.children[0], this.data, Object.assign(this.options, {
        labelsDiv: this.legend.nativeElement
      }))
    })
  }

}
