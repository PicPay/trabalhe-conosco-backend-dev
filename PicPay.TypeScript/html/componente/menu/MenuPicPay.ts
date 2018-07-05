// #region Reference

/// <reference path="../../../../OWeb.TypeScript/erro/Erro.ts"/>
/// <reference path="../../../../OWeb.TypeScript/html/componente/menu/MenuBase.ts"/>
/// <reference path="../../../../OWeb.TypeScript/html/componente/menu/MenuItem.ts"/>
/// <reference path="../../../../OWeb.TypeScript/Objeto.ts"/>
/// <reference path="../../../../OWeb.TypeScript/OnClickListener.ts"/>

// #endregion Reference

module PicPay
{
    // #region Importações

    import Erro = OWeb.Erro;
    import MenuBase = OWeb.MenuBase;
    import MenuItem = OWeb.MenuItem;
    import Objeto = OWeb.Objeto;
    import OnClickListener = OWeb.OnClickListener;

    // #endregion Importações

    // #region Enumerados
    // #endregion Enumerados

    export class MenuPicPay extends MenuBase implements OnClickListener
    {
        // #region Constantes
        // #endregion Constantes

        // #region Atributos

        private _mniSair: MenuItem;

        private get mniSair(): MenuItem
        {
            if (this._mniSair != null)
            {
                return this._mniSair;
            }

            this._mniSair = new MenuItem(this.strId + "_mniSair");

            return this._mniSair;
        }

        // #endregion Atributos

        // #region Construtor

        // #endregion Construtor

        // #region Métodos

        protected inicializar(): void
        {
            super.inicializar();

            this.inicializarMniSair()
        }

        private inicializarMniSair(): void
        {
            this.mniSair.mnu = this;

            this.mniSair.iniciar();
        }

        private sair(): void
        {
            AppPicPay.i.srvAjaxDbe.sair().sucesso(b => window.location.href = "/login");
        }

        protected setEventos(): void
        {
            super.setEventos();

            this.mniSair.addEvtOnClickListener(this);
        }

        // #endregion Métodos

        // #region Eventos

        public onClick(objSender: Objeto, arg: JQueryEventObject): void
        {
            super.onClick(objSender, arg);

            try
            {
                switch (objSender)
                {
                    case this.mniSair:
                        this.sair();
                        return;
                }
            }
            catch (ex)
            {
                new Erro("Algo deu errado.", ex);
            }
        }

        // #endregion Eventos
    }
}