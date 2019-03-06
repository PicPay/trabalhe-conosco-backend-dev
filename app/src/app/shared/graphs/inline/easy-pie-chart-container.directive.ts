import {
  Directive, OnInit, ElementRef, AfterContentChecked, AfterViewChecked, AfterViewInit,
  AfterContentInit
} from '@angular/core';

import 'script-loader!smartadmin-plugins/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js';

declare var $: any;

@Directive({
  selector: '[saEasyPieChartContainer]'
})
export class EasyPieChartContainer implements AfterContentChecked, AfterContentInit{

  constructor(private container: ElementRef) {}

  render(){

    $('.easy-pie-chart', this.container.nativeElement).each(function(idx, element) {

      const $this = $(element),
        barColor = $this.css('color') || $this.data('pie-color'),
        trackColor = $this.data('pie-track-color') || 'rgba(0,0,0,0.04)',
        size = parseInt($this.data('pie-size')) || 25;

      $this.easyPieChart({

        barColor : barColor,
        trackColor : trackColor,
        scaleColor : false,
        lineCap : 'butt',
        lineWidth : size / 8.5,
        animate : 1500,
        rotate : -90,
        size : size,
        onStep: function(from, to, percent) {
          $(this.el).find('.percent').text(Math.round(percent));
        }

      });
    });

  }

  private counter = 0;

  ngAfterContentChecked(){
    let counter = $('.easy-pie-chart').length;
    if(counter != this.counter){
      this.counter = counter;
      setTimeout(()=>{
        this.render()
      }, 25)
    }

  }

  ngAfterContentInit(){
    this.render()
  }



}
