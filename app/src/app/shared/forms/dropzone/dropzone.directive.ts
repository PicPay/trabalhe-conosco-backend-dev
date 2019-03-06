import {Directive, Input, ElementRef} from '@angular/core';


declare var Dropzone: any;

@Directive({
  selector: '[saDropzone]'
})
export class DropzoneDirective {

  @Input() saDropzone:any;

  private dropzone:any;

  constructor(private el:ElementRef) {
    System.import('dropzone').then((Dropzone)=> {
      this.initDropzone(Dropzone)
    })
  }



  initDropzone(Dropzone) {
    Dropzone.autoDiscover = false;
    this.dropzone = new Dropzone(this.el.nativeElement, this.saDropzone || {});
  }

}
