import {Component, OnInit, Input, ElementRef, EventEmitter, Output, AfterContentChecked} from '@angular/core';

declare var $:any;

@Component({
  selector: 'x-editable',
  template: '<a attr.id="{{widgetId}}" class="{{className}}"><ng-content></ng-content>{{model }}</a>'
})
export class XEditableComponent implements OnInit, AfterContentChecked {

  @Input() model:any = '';
  @Output() modelChange = new EventEmitter();

  @Input() type:any = 'text';
  @Input() placement:any;
  @Input() value:any;
  @Input() mode:any;
  @Input() disabled:any = false;
  @Input() placeholder:any;
  @Input() originalTitle:any;
  @Input() source:any;
  @Input() showbuttons:any;
  @Input() template:any;
  @Input() viewformat:any;
  @Input() format:any;
  @Input() className:any;
  @Input() pk:any;

  public widgetId:any;

  private _options:any;

  constructor(private el:ElementRef) {
    this.widgetId = 'x-editable' + XEditableComponent.widgetsCounter++

  }

  ngOnInit() {
    System.import('X-editable/dist/bootstrap3-editable/js/bootstrap-editable.js').then(()=> {
      this.render()
    })
  }

  ngAfterContentChecked() {
    if (this._options && ['type',
        'placement',
        'mode',
        'value',
        'disabled',
        'placeholder',
        'originalTitle',
        'source',
        'showbuttons',

        'template',
        'viewformat',
        'format',
        'pk',
      ].some((it)=> {
        return this._options[it] != this[it]
      })) {
      this.render()
    }

  }

  render() {
    let element = $(this.el.nativeElement);
    let options = {
      type: this.type,
      placement: this.placement,
      mode: this.mode,
      value: this.value,
      disabled: this.disabled,
      placeholder: this.placeholder,
      originalTitle: this.originalTitle,
      source: this.source,
      showbuttons: this.showbuttons,
      template: this.template,
      viewformat: this.viewformat,
      format: this.format,
      pk: this.pk,
    };

    element.editable('destroy');
    element.editable(options);

    element.on('save', (e, params)=> {
      this.model = params.newValue;
      this.modelChange.emit(params.newValue);
    });

    this._options = options
  }


  static widgetsCounter = 0

}
