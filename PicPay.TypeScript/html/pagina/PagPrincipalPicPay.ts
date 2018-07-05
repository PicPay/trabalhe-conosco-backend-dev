// #region Reference

/// <reference path="../../../OWeb.TypeScript/database/TabelaWeb.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/componente/menu/MenuBase.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/Div.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/pagina/PagPrincipalBase.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/Tag.ts"/>
/// <reference path="../../AppPicPay.ts"/>
/// <reference path="../componente/menu/MenuPicPay.ts"/>

// #endregion Reference

module PicPay
{
    // #region Importações

    import Div = OWeb.Div;
    import MenuBase = OWeb.MenuBase;
    import PagPrincipalBase = OWeb.PagPrincipalBase;
    import TabelaWeb = OWeb.TabelaWeb;
    import Tag = OWeb.Tag;

    // #endregion Importações

    // #region Enumerados
    // #endregion Enumerados

    export class PagPrincipalPicPay extends PagPrincipalBase
    {
        // #region Constantes
        // #endregion Constantes

        // #region Atributos

        protected static _i: PagPrincipalPicPay;

        public static get i(): PagPrincipalPicPay
        {
            if (PagPrincipalPicPay._i != null)
            {
                return PagPrincipalPicPay._i;
            }

            PagPrincipalPicPay._i = new PagPrincipalPicPay();

            return PagPrincipalPicPay._i;
        }

        private _mnuPicPay: MenuPicPay;

        private get mnuPicPay(): MenuPicPay
        {
            if (this._mnuPicPay != null)
            {
                return this._mnuPicPay;
            }

            this._mnuPicPay = new MenuPicPay(this);

            return this._mnuPicPay;
        }

        // #endregion Atributos

        // #region Construtores

        // #endregion Construtores

        // #region Métodos

        protected getMnu(): MenuBase
        {
            return this.mnuPicPay;
        }

        protected inicializar(): void
        {
            super.inicializar();

            AppPicPay.i.iniciar(this);
        }

        // #endregion Métodos

        // #region Eventos
        // #endregion Eventos
    }
}