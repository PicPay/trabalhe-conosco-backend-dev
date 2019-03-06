import { Component, OnInit } from '@angular/core';

@Component({
  
  selector: 'sa-file-input',
  template: `
    <div class="input input-file">
        <span class="button"><input type="file" #file  (change)="viewport.value = file.value"/>Browse</span><input #viewport type="text" placeholder="Include some files" readonly/>
    </div>
  `,
})
export class FileInputComponent implements OnInit {

  constructor() {}

  ngOnInit() {
  }

}
