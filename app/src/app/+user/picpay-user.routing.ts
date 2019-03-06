import { NgModule } from '@angular/core'
import { RouterModule, Routes } from "@angular/router"

export const routes: Routes = [
    {
        path: 'user-mysql',
        loadChildren: './+user-mysql/user-mysql.module#UserMysqlModule'
    },
    {
        path: 'user-es',
        loadChildren: './+user-es/user-es.module#UserEsModule',
    }
]

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule],
    providers: []
})
export class PicpayUserRoutingModule { }
