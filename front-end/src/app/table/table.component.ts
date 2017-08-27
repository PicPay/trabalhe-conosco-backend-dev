import { Component, OnInit } from '@angular/core';
import { DataService } from '../services/data.service';
;
@Component({
  selector: 'app-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.css']
})
export class TableComponent implements OnInit {
  offset: number;
  registers: Register[];
  loading: boolean;

  constructor(private dataService: DataService)  { }

  findRegister(value){
    this.loading = true;
    this.dataService.getRegisters(value, this.offset).subscribe(registers => {
      this.loading = false;
      this.registers = registers.data;
      console.log(this.registers);
    }, err => {
      console.log(err);
    });
  }
  ngOnInit() {
    this.offset = 1;
    // this.findRegister("Luiz");
  }
  incrementOffset(value) {
    this.offset++;
    this.findRegister(value);
  }
  decrementOffset(value) {
    this.offset--;
    this.findRegister(value);
  }

}
interface Register {
  id: string,
  name: string,
  username: string;
}
