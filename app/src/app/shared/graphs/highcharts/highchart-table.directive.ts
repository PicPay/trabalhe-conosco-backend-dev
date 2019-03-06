import {Directive, ElementRef, OnInit, Input} from '@angular/core';


declare var $: any;

@Directive({
  selector: '[saHighchartTable]'
})
export class HighchartTable implements OnInit{

  @Input() saHighchartTable: any;

  constructor(private el: ElementRef) {}

  ngOnInit(){
    // to improve latency for big components smartadmin app we are loading some dependencies async
    System.import('script-loader!highcharts').then(()=>{
      return System.import('script-loader!smartadmin-plugins/bower_components/highchartTable/jquery.highchartTable.js')
    }).then(()=>{
      $(this.el.nativeElement).highchartTable();
    })


  }

}
