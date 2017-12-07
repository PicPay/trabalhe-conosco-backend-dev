import { Component, OnInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-search-bar',
  templateUrl: './search-bar.component.html',
  styleUrls: ['./search-bar.component.css']
})
export class SearchBarComponent implements OnInit {

  @Output('onFilterChanged') onFilterChangedEmiter: EventEmitter<any> = new EventEmitter<any>();

  constructor() { }

  ngOnInit() {
  }

  /**
   * Emite o evento da filtragem da tabela.
   *
   * @param filter conteúdo do input de texto
   * @author L.Gomes
   */
  filterUsers(filter: string): void {
    this.onFilterChangedEmiter.emit({filterActive: filter});
  }

}
