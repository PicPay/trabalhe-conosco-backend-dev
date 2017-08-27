import { Component, OnInit } from '@angular/core';
import { DataService } from '../services/data.service';
@Component({
  selector: 'app-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.css']
})
export class TableComponent implements OnInit {
  offset:number;
  registers:Register[];

  constructor(private dataService:DataService) { }

  buscar(value){
    this.dataService.getRegisters(value, 1).subscribe(registers => {
      this.registers = registers.data;
      console.log(this.registers);
    }, err => {
      console.log(err);
    });
  }
  ngOnInit() {
    this.offset=0;
  }

}
interface Register{
  id: string,
  name: string,
  username: string;
}