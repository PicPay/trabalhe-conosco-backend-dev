import { Routes, RouterModule } from '@angular/router'
import { ModuleWithProviders } from "@angular/core"

import { MainLayoutComponent } from "./shared/layout/app-layouts/main-layout.component"

export const routes: Routes = [
    {
        path: '',
        component: MainLayoutComponent,
        data: {pageTitle: 'Home'},
        children: [
            {
                path: '', redirectTo: 'picpay/user-mysql', pathMatch: 'full'
            },
            {
                path: 'picpay/user-mysql',
                loadChildren: './+user/+user-mysql/user-mysql.module#UserMysqlModule'
            },
            {
                path: 'picpay/user-es',
                loadChildren: './+user/+user-es/user-es.module#UserEsModule'
            }
        ]
  },
  {path: '**', redirectTo: 'miscellaneous/error404'}
];

export const routing: ModuleWithProviders = RouterModule.forRoot(routes, {useHash: true});
