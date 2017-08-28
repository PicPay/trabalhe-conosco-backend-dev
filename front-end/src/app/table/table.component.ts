import {Component, ElementRef, HostListener, OnInit, ViewChild} from '@angular/core';
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
  // @ViewChild('nameInput') nameInput: ElementRef;

  constructor(private dataService: DataService)  { }
  // @HostListener('Document:keydown', ['$event'])
  // keyPress(event: KeyboardEvent){
  //   if(event.keyCode === 75)  {
  //     this.incrementOffset(this.nameInput.nativeElement.value);
  //   } else if(event.keyCode === 74) {
  //     this.decrementOffset(this.nameInput.nativeElement.value);
  //   }
  // }
  findRegister(value){
    this.offset = 1;
    this.loading = true;
    this.findRegisterAux(value);
  }
  findRegisterAux(value) {
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
  }


  incrementOffset(value) {
    this.offset++;
    this.findRegisterAux(value);
  }
  decrementOffset(value) {
    this.offset--;
    this.findRegisterAux(value);
  }

}
interface Register {
  id: string,
  name: string,
  username: string;
}
