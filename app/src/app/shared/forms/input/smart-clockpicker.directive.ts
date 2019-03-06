import {Directive, ElementRef, OnInit, Input} from '@angular/core';

declare var $: any;

@Directive({
  selector: '[smartClockpicker]'
})
export class SmartClockpickerDirective implements OnInit {

  @Input() smartClockpicker: any;

  constructor(private el:ElementRef) {
  }

  ngOnInit() {
    System.import('script-loader!clockpicker/dist/bootstrap-clockpicker.min.js').then(()=> {
      this.render()
    })
  }


  render() {
    $(this.el.nativeElement).clockpicker(this.smartClockpicker || {
      placement: 'top',
      donetext: 'Done'
    });
  }

}
