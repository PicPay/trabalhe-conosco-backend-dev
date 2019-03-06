import {Component, Input, ElementRef, AfterContentInit, OnInit} from '@angular/core';

declare var $: any;

@Component({

    selector: 'sa-datatable',
    template: `
        <table class="dataTable responsive {{tableClass}}" width="{{width}}">
        <ng-content></ng-content>
        </table>
    `,
    styles: [
        require('smartadmin-plugins/datatables/datatables.min.css')
    ]
})
export class DatatableComponent implements OnInit {

    datatable: any = undefined

    @Input() public options:any;
    @Input() public filter:any;
    @Input() public detailsFormat:any;

    @Input() public paginationLength: boolean;
    @Input() public columnsHide: boolean;
    @Input() public tableClass: string;
    @Input() public width: string = '100%';

    constructor(private el: ElementRef) {
    }

    ngOnInit() {
        Promise.all([
            System.import('script-loader!smartadmin-plugins/datatables/datatables.min.js'),
        ]).then(()=>{
            this.render()
        })
    }

    render() {
        let element = $(this.el.nativeElement.children[0]);
        let options = this.options || {}

        let toolbar = '';
        if (options.buttons)
        toolbar += 'B';
        if (this.paginationLength)
        toolbar += 'l';
        if (this.columnsHide)
        toolbar += 'C';

        if (typeof options.ajax === 'string') {
            let url = options.ajax;
            options.ajax = {
                url: url,
                // complete: function (xhr) {
                //
                // }
            }
        }

        // FIXME: Mudar a forma como é feito o merge do datatables e facilitar para troca de idioma
        options = $.extend(options, {
            "dom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs text-right'" + toolbar + ">r>" +
            "t" +
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            // oLanguage: {
            //     "sSearch": "<span class='input-group-addon'><i class='glyphicon glyphicon-search'></i></span> ",
            //     "sLengthMenu": "_MENU_"
            // },
            "autoWidth": false,
            retrieve: true,
            responsive: true,
            initComplete: (settings, json)=> {
                element.parent().find('.input-sm', ).removeClass("input-sm").addClass('input-md');
            }
        });

        this.datatable = element.DataTable(options);

        if (this.filter) {
            // Apply the filter
            element.on('keyup change', 'thead th input[type=text]', function () {
                this.datatable
                .column($(this).parent().index() + ':visible')
                .search(this.value)
                .draw();

            });
        }


        if (!toolbar) {
            element.parent().find(".dt-toolbar").append('<div class="text-right"><img src="assets/img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');
        }

        if(this.detailsFormat){
            let format = this.detailsFormat
            element.on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = this.datatable.row( tr );
                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            })
        }

    }

    reloadAjax(){
        if(this.datatable){
            this.datatable.ajax.reload()
        }
    }
}
