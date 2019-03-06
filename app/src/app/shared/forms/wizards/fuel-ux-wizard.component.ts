import {Component, OnInit, ElementRef, EventEmitter, Output} from '@angular/core';

declare var $: any;

@Component({
  selector: 'fuel-ux-wizard',
  template: `
    <div>
      <ng-content></ng-content>
    </div>
  `,
  styles: []
})
export class FuelUxWizardComponent implements OnInit {

  @Output() complete = new EventEmitter();

  constructor(private el: ElementRef) { }

  ngOnInit() {
    System.import('script-loader!fuelux/js/wizard.js').then(()=>{
      this.render()
    })
  }

  render(){
    const element = $(this.el.nativeElement);
    const wizard = element.wizard();

    const $form = element.find('form');

    wizard.on('actionclicked.fu.wizard', (e, data)=>{
      if ($form.data('validator')) {
        if (!$form.valid()) {
          $form.data('validator').focusInvalid();
          e.preventDefault();
        }
      }
    });

    wizard.on('finished.fu.wizard', (e, data) =>{
      const formData = {};
      $form.serializeArray().forEach((field)=>{
        formData[field.name] = field.value
      });
      this.complete.emit(formData)
    });

  }

}
