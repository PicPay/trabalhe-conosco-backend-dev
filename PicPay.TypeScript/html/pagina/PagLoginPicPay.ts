// #region Reference

/// <reference path="../../../OWeb.TypeScript/erro/Erro.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/componente/botao/BotaoCircular.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/componente/Mensagem.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/componente/Notificacao.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/Div.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/Input.ts"/>
/// <reference path="../../../OWeb.TypeScript/html/pagina/PagMobile.ts"/>
/// <reference path="../../../OWeb.TypeScript/Keys.ts"/>
/// <reference path="../../../OWeb.TypeScript/OnClickListener.ts"/>
/// <reference path="../../../OWeb.TypeScript/OnKeyDownListener.ts"/>
/// <reference path="../../../OWeb.TypeScript/Utils.ts"/>

// #endregion Reference

module PicPay
{
    // #region Importações

    import BotaoCircular = OWeb.BotaoCircular;
    import Div = OWeb.Div;
    import Erro = OWeb.Erro;
    import Input = OWeb.Input;
    import Keys = OWeb.Keys;
    import Mensagem = OWeb.Mensagem;
    import Notificacao = OWeb.Notificacao;
    import OnClickListener = OWeb.OnClickListener;
    import OnKeyDownListener = OWeb.OnKeyDownListener;
    import PagMobile = OWeb.PagMobile;
    import Utils = OWeb.Utils;

    // #endregion Importações

    // #region Enumerados
    // #endregion Enumerados

    export class PagLoginPicPay extends PagMobile implements OnKeyDownListener, OnClickListener
    {
        // #region Constantes
        // #endregion Constantes

        // #region Atributos

        protected static _i: PagLoginPicPay;

        public static get i(): PagLoginPicPay
        {
            if (PagLoginPicPay._i != null)
            {
                return PagLoginPicPay._i;
            }

            PagLoginPicPay._i = new PagLoginPicPay();

            return PagLoginPicPay._i;
        }

        private _btnEntrar: BotaoCircular;
        private _divConteudo: Div;
        private _divLoginInfo: Div;
        private _txtLogin: Input;
        private _txtSenha: Input;

        private get btnEntrar(): BotaoCircular
        {
            if (this._btnEntrar != null)
            {
                return this._btnEntrar;
            }

            this._btnEntrar = new BotaoCircular(this.strId + "_btnEntrar");

            return this._btnEntrar;
        }

        private get divConteudo(): Div
        {
            if (this._divConteudo != null)
            {
                return this._divConteudo;
            }

            this._divConteudo = new Div(this.strId + "_divConteudo");

            return this._divConteudo;
        }

        private get divLoginInfo(): Div
        {
            if (this._divLoginInfo != null)
            {
                return this._divLoginInfo;
            }

            this._divLoginInfo = new Div(this.strId + "_divLoginInfo");

            return this._divLoginInfo;
        }

        private get txtLogin(): Input
        {
            if (this._txtLogin != null)
            {
                return this._txtLogin;
            }

            this._txtLogin = new Input(this.strId + "_txtLogin");

            return this._txtLogin;
        }

        private get txtSenha(): Input
        {
            if (this._txtSenha != null)
            {
                return this._txtSenha;
            }

            this._txtSenha = new Input(this.strId + "_txtSenha");

            return this._txtSenha;
        }

        // #endregion Atributos

        // #region Construtores
        // #endregion Construtores

        // #region Métodos

        protected finalizar(): void
        {
            super.finalizar();

            this.txtLogin.receberFoco();
        }

        protected inicializar(): void
        {
            super.inicializar();

            AppPicPay.i.iniciar(this);

            this.btnEntrar.iniciar();
            this.txtLogin.iniciar();
            this.txtSenha.iniciar();

            this.divConteudo.anm.cair();
        }

        private login(): void
        {
            this.validarDados();

            AppPicPay.i.srvAjaxDbe.login(this.txtLogin.strValor, this.txtSenha.strValor).sucesso(b => this.loginSucesso(b));
        }

        private loginSucesso(booResultado: boolean): void
        {
            if (booResultado)
            {
                window.location.reload(true);
            }
            else
            {
                this.loginSucessoInvalido();
            }
        }

        private loginSucessoInvalido(): void
        {
            this.divConteudo.anm.balancar(() => this.divLoginInfo.anm.cair());

            Notificacao.erro("Login inválido.");
        }

        protected setEventos(): void
        {
            super.setEventos();

            this.btnEntrar.addEvtOnClickListener(this);
            this.txtLogin.addEvtOnKeyDownListener(this);
            this.txtSenha.addEvtOnKeyDownListener(this);
        }

        private validarDados(): void
        {
            if (Utils.getBooStrVazia(this.txtLogin.strValor))
            {
                this.txtLogin.receberFoco();

                throw new Error("O login deve ser informado.");
            }

            if (Utils.getBooStrVazia(this.txtSenha.strValor))
            {
                this.txtSenha.receberFoco();

                throw new Error("A senha deve ser informada.");
            }
        }

        // #endregion Métodos

        // #region Eventos

        public onKeyDown(objSender: Object, arg: JQueryKeyEventObject): void
        {
            try
            {
                if (arg.keyCode != Keys.ENTER)
                {
                    return;
                }

                switch (objSender)
                {
                    case this.txtLogin:
                    case this.txtSenha:
                        this.login();
                        return;
                }
            }
            catch (ex)
            {
                new Erro("Erro desconhecido.", ex);
            }
        }

        public onClick(objSender: Object, arg: any): void
        {
            try
            {
                this.login();
            }
            catch (ex)
            {
                new Erro("Erro desconhecido.", ex);
            }
        }

        // #endregion Eventos
    }
}