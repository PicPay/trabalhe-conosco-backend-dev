import {
  Component, Input, ElementRef, AfterContentInit, OnDestroy,
  ChangeDetectionStrategy, ViewEncapsulation, OnInit
} from '@angular/core';
import {WORLD_MILL} from "./world-mill";

import 'jquery-mousewheel/jquery.mousewheel.js';
import 'jvectormap/jquery-jvectormap.min.js';

declare var $: any;

$.fn.vectorMap('addMap', 'world_mill', WORLD_MILL);

@Component({
  selector: 'vector-map',
  changeDetection: ChangeDetectionStrategy.OnPush,
  encapsulation: ViewEncapsulation.None,
  template: '<div ngNonBindable class="vector-map vector-map-pane" style="height: 300px;"></div>',
  styleUrls: ['./vector-map.component.css']
})
export class VectorMapComponent implements OnInit, OnDestroy {

  @Input() data: any;


  constructor(private el: ElementRef) { }

  ngOnInit() {
    // System.import('jvectormap/jquery-jvectormap.min.js').then(()=>{

     this.render()
    // })

  }


  render(){
    const data = Object.assign({}, this.data);
    $('.vector-map-pane', this.el.nativeElement).vectorMap({
      map: 'world_mill',
      backgroundColor: 'white',
      zoomOnScroll: false,
      series: {
       regions: [{
          values: data,
          scale: ['#C8EEFF', '#0071A4'],
          normalizeFunction: 'polynomial'
        }]
      },
      onRegionTipShow: (e, el, code)=>{
        el.html(el.html()+' (GDP - '+data[code]+')');
        e.preventDefault()
      },

      onRegionOver: (e)=>{e.preventDefault()},
      onRegionOut: (e)=>{e.preventDefault()},
      onRegionClick: (e)=>{e.preventDefault()},
      onRegionSelected: (e)=>{e.preventDefault()},
      onMarkerTipShow: (e)=>{e.preventDefault()},
      onMarkerOver: (e)=>{e.preventDefault()},
      onMarkerOut: (e)=>{e.preventDefault()},
      onMarkerClick: (e)=>{e.preventDefault()},
      onMarkerSelected: (e)=>{e.preventDefault()},
      onViewportChange: (e)=>{
          console.log(e)
        e.preventDefault()}
    });






    // this.mapObject = $vectorMap.vectorMap('get', 'mapObject');
    $('.jvectormap-zoomin', this.el.nativeElement).html('<i class="fa fa-plus"></i>')
    $('.jvectormap-zoomout', this.el.nativeElement).html('<i class="fa fa-minus"></i>')

  }


  ngOnDestroy(){
    let mapObject =  $('.vector-map-pane', this.el.nativeElement).vectorMap('get', 'mapObject');

    mapObject && mapObject.remove()
  }
}
