import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import {
  MainComponent,
} from './components';

const routes: Routes = [
  { path: '', component: MainComponent },
  // { path: '404', component: NotFound404Component },
  // { path: '403', component: Forbidden403Component },
  { path: '**', redirectTo: '404' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutes { }
