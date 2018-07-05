// #region Reference

/// <reference path="../OWeb.TypeScript/AppWebBase.ts"/>
/// <reference path="../OWeb.TypeScript/design/TemaDefault.ts"/>
/// <reference path="../OWeb.TypeScript/server/ajax/dbe/SrvAjaxDbeBase.ts"/>
/// <reference path="../OWeb.TypeScript/server/ServerBase.ts"/>
/// <reference path="../OWeb.TypeScript/server/SrvHttpBase.ts"/>
/// <reference path="server/SrvAjaxDbePicPay.ts"/>
/// <reference path="server/SrvHttpPicPay.ts"/>
/// <reference path="TemaPicPay.ts"/>

// #endregion Reference

module PicPay
{
    // #region Importações

    import AppWebBase = OWeb.AppWebBase;
    import ServerBase = OWeb.ServerBase;
    import SrvAjaxDbeBase = OWeb.SrvAjaxDbeBase;
    import SrvHttpBase = OWeb.SrvHttpBase;
    import TemaDefault = OWeb.TemaDefault;

    // #endregion Importações

    // #region Enumerados
    // #endregion Enumerados

    export class AppPicPay extends AppWebBase
    {
        // #region Constantes
        // #endregion Constantes

        // #region Atributos

        protected static _i: AppPicPay;

        public static get i(): AppPicPay
        {
            if (AppPicPay._i != null)
            {
                return AppPicPay._i;
            }

            AppPicPay._i = new AppPicPay();

            return AppPicPay._i;
        }

        // #endregion Atributos

        // #region Construtores
        // #endregion Construtores

        // #region Métodos

        protected getObjTema(): TemaDefault
        {
            return new TemaPicPay();
        }

        protected inicializar(): void
        {
            super.inicializar();

            this.strNome = "PicPay";
        }

        protected inicializarArrSrv(arrSrv: Array<ServerBase>): void
        {
            arrSrv.push(new SrvAjaxDbePicPay());
            arrSrv.push(new SrvHttpPicPay());
        }

        // #endregion Métodos

        // #region Eventos

        // #endregion Eventos
    }
}