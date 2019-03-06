import { Component, OnInit, ElementRef, AfterContentInit, Input, OnChanges, SimpleChanges } from '@angular/core';

declare var Morris:any;

@Component({

    selector: 'sa-morris-graph',
    template: `
    <div class="chart no-padding" ></div>
    `,
    styles: []
})
export class MorrisGraphComponent implements AfterContentInit, OnChanges {

    private chart: any;

    @Input() public data:any;
    @Input() public options:any;
    @Input() public type:string;

    constructor(private el:ElementRef) {
    }

    ngAfterContentInit() {

        System.import('script-loader!raphael').then(()=> {
            return System.import('morris.js/morris.js')
        }).then(()=> {
            options.element = this.el.nativeElement.children[0];
            options.data = this.data;

            switch (this.type) {
                case 'area':
                this.chart = Morris.Area(options);
                break;
                case 'bar':
                this.chart = Morris.Bar(options);
                break;
                case 'line':
                this.chart = Morris.Line(options);
                break;
                case 'donut':
                this.chart = Morris.Donut(options);
                break;
            }

            // Por ser assíncrono o ngOnChanges estava sendo chamado antes desse método terminar.
            // Isso fazia com que os dados de inicialização do gráfico não fosse setados, pois o
            // this.chart ainda estava undefined.
            // Com o código abaixo obriga-se a utilização dos dados mais atuais no gráfico após a
            // sua "criação de fato"
            this.chart.options.ykeys = this.options.ykeys;
            this.chart.options.labels = this.options.labels;
            this.chart.setData(this.data);
        });
        let options = this.options || {};
    }

    ngOnChanges(changes: SimpleChanges) {
        if(this.chart !== undefined){
            // TODO: Ver uma forma de identificar quais propriedades das opções sofreram alterações
            if(changes.hasOwnProperty('options')){
                if(changes.options.currentValue.hasOwnProperty('labels')){
                    this.chart.options.labels = changes.options.currentValue.labels;
                }
                if(changes.options.currentValue.hasOwnProperty('ykeys')){
                    this.chart.options.ykeys = changes.options.currentValue.ykeys;
                }
            }
            if(changes.hasOwnProperty('data')){
                this.chart.setData(changes.data.currentValue);
            }
        }
    }

}
