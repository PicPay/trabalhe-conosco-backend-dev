import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {SummernoteDirective} from './summernote.directive'
import {SummernoteAttachDirective} from './summernote-attach.directive'
import {SummernoteDetachDirective} from './summernote-detach.directive'
import {MarkdownEditorDirective} from './markdown-editor.directive'

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [
    SummernoteDirective,
    SummernoteAttachDirective,
    SummernoteDetachDirective,
    MarkdownEditorDirective,
  ],
  exports: [
    SummernoteDirective,
    SummernoteAttachDirective,
    SummernoteDetachDirective,
    MarkdownEditorDirective,
  ]
})
export class SmartadminEditorsModule { }
