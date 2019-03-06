import {Component, OnInit, OnChanges, ElementRef, Input, Output, EventEmitter, Renderer} from '@angular/core';

@Component({

  selector: 'sa-tree-view',
  template: '<div class="sa-tree-view tree"></div>',
})
export class TreeViewComponent implements OnChanges {

  @Input() items: any;
  @Output() change = new EventEmitter<any>();

  constructor(private el:ElementRef, private renderer: Renderer) {
  }

  ngOnChanges() {
    this.items && this.render();
  }

  private render(){
    const root = this.el.nativeElement.getElementsByTagName('div')[0];
    root.appendChild(this.createBranch(this.items, {expanded: true}));
  }


  private createChild(item) {
    let i, branch;
    const li = document.createElement('li');
    li.innerHTML = item.content;

    if (item.children){
      li.className += ' parent_li';

      i = this.addPlusMinusSign(li, item);

      branch = this.createBranch(item.children, item);

      li.appendChild(branch)
    }

    this.renderer.listen(li, 'click', (event) => {
      event.stopPropagation();



      if(item.children){
        item.expanded = !item.expanded
        this.togglePlusMinusSign(i, item)
        branch.className = item.expanded ? '' : 'hidden'
      }

      this.change.emit(item)
    });

    return li;
  }

  private createBranch(items, parent: any) {
    const ul = document.createElement('ul');
    items.forEach(item=> {
      ul.appendChild(this.createChild(item))
    });


    ul.className = parent.expanded ? '' : 'hidden';

    return ul
  }

  private addPlusMinusSign(li, item){
    const i = document.createElement('i');

    this.togglePlusMinusSign(i, item);
    const span = li.getElementsByTagName('span')[0]

    if(span){
      span.appendChild(i)
    }else{
      li.appendChild(i)
    }

    return i
  }

  private togglePlusMinusSign(i, item){
    i.className = item.expanded ? 'sa-icon fa fa-lg fa-minus-circle' : 'sa-icon fa fa-lg fa-plus-circle'
  }

}
