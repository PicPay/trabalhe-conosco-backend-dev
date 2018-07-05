using OBase;
using OWeb;
using OWeb.DataBase.Dominio;
using OWeb.Html;
using OWeb.Html.Componente.Botao;
using OWeb.Html.Componente.Form;
using OWeb.Html.Pagina;
using OWeb.Server;
using OWeb.Server.Ajax;
using OWeb.Server.Ajax.Dbe;
using OWeb.Server.Arquivo.Css;
using PicPay.Html.Componente;
using PicPay.Server;

namespace PicPay.Html.Pagina
{
    [HtmlExport]
    internal class PagLoginPicPay : PagMobile
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private BotaoCircular _btnEntrar;
        private Div _divConteudo;
        private Div _divLoginInfo;
        private Div _divLogo;
        private FormHtml _frmLogin;
        private Tag _tagLinkAppManifest;
        private Input _txtLogin;
        private Input _txtSenha;

        private BotaoCircular btnEntrar
        {
            get
            {
                if (_btnEntrar != null)
                {
                    return _btnEntrar;
                }

                _btnEntrar = new BotaoCircular();

                return _btnEntrar;
            }
        }

        private Div divConteudo
        {
            get
            {
                if (_divConteudo != null)
                {
                    return _divConteudo;
                }

                _divConteudo = new Div();

                return _divConteudo;
            }
        }

        private Div divLoginInfo
        {
            get
            {
                if (_divLoginInfo != null)
                {
                    return _divLoginInfo;
                }

                _divLoginInfo = new Div();

                return _divLoginInfo;
            }
        }

        private Div divLogo
        {
            get
            {
                if (_divLogo != null)
                {
                    return _divLogo;
                }

                _divLogo = new Div();

                return _divLogo;
            }
        }

        private FormHtml frmLogin
        {
            get
            {
                if (_frmLogin != null)
                {
                    return _frmLogin;
                }

                _frmLogin = new FormHtml();

                return _frmLogin;
            }
        }

        private Tag tagLinkAppManifest
        {
            get
            {
                if (_tagLinkAppManifest != null)
                {
                    return _tagLinkAppManifest;
                }

                _tagLinkAppManifest = new Tag("link");

                return _tagLinkAppManifest;
            }
        }

        private Input txtLogin
        {
            get
            {
                if (_txtLogin != null)
                {
                    return _txtLogin;
                }

                _txtLogin = new Input();

                return _txtLogin;
            }
        }

        private Input txtSenha
        {
            get
            {
                if (_txtSenha != null)
                {
                    return _txtSenha;
                }

                _txtSenha = new Input();

                return _txtSenha;
            }
        }

        #endregion Atributos

        #region Construtores

        public PagLoginPicPay() : base("Login")
        {
        }

        #endregion Construtores

        #region Métodos

        protected override void addConstante(JavaScriptTag tagJs)
        {
            base.addConstante(tagJs);

            tagJs.addConstante((nameof(SrvAjaxDbePicPay) + "_porta"), SrvAjaxDbePicPay.i.intPorta);
        }

        protected override void addCss(LstTag<CssTag> lstCss)
        {
            base.addCss(lstCss);

            lstCss.Add(new CssTag(AppWebBase.DIR_CSS + "font.css"));
        }

        protected override void addJs(LstJavaScriptTag lstJs)
        {
            base.addJs(lstJs);

            lstJs.Add(new JavaScriptTag(typeof(AppPicPay)));
            lstJs.Add(new JavaScriptTag(typeof(DominioWebBase)));
            lstJs.Add(new JavaScriptTag(typeof(Interlocutor), 199));
            lstJs.Add(new JavaScriptTag(typeof(ServerBase)));
            lstJs.Add(new JavaScriptTag(typeof(SrvAjaxBase)));
            lstJs.Add(new JavaScriptTag(typeof(SrvAjaxDbeBase)));
            lstJs.Add(new JavaScriptTag(typeof(SrvAjaxDbePicPay), 201));
            lstJs.Add(new JavaScriptTag(typeof(SrvHttpBase)));
            lstJs.Add(new JavaScriptTag(typeof(SrvHttpPicPay)));
            lstJs.Add(new JavaScriptTag(typeof(TemaPicPay), 250));
        }

        protected override void addJsLib(LstJavaScriptTag lstJsLib)
        {
            base.addJsLib(lstJsLib);

            lstJsLib.Add(new JavaScriptTag(AppWebBase.DIR_JS_LIB + "md5.min.js"));
        }

        protected override bool getBooJsAutoInicializavel()
        {
            return true;
        }

        protected override void inicializar()
        {
            base.inicializar();

            this.srcIcone = (AppWebBase.DIR_MEDIA_PNG + "favicon.png");
            this.strId = this.GetType().Name;

            this.divLoginInfo.strConteudo = "Como isso é apenas um teste eu vou te contar, o login é \"user\" e a senha é \"123\" :)";
            this.txtLogin.strPlaceHolder = "Login";

            this.inicializarBtnEntrar();
            this.inicializarTagLinkAppManifest();
            this.inicializarTxtSenha();
        }

        protected override void montarLayout()
        {
            base.montarLayout();

            this.tagLinkAppManifest.setPai(this.tagHead);

            this.divConteudo.setPai(this);

            this.divLogo.setPai(this.divConteudo);

            this.frmLogin.setPai(this.divConteudo);

            this.txtLogin.setPai(this.frmLogin);

            this.txtSenha.setPai(this.frmLogin);

            this.btnEntrar.setPai(this.frmLogin);

            this.divLoginInfo.setPai(this.divConteudo);

            new DivRodape().setPai(this);
        }

        protected override void setCss(CssArquivoBase css)
        {
            base.setCss(css);

            this.addCss(css.addCss("flex-direction", "column"));
            this.addCss(css.setAlignItems("center"));
            this.addCss(css.setBackgroundColor(AppWebBase.i.objTema.corPrimaria));
            this.addCss(css.setDisplayFlex());
            this.addCss(css.setOverflowHidden());

            this.btnEntrar.addCss(css.setBackgroundColor(AppPicPay.i.objTema.corPrimaria));
            this.btnEntrar.addCss(css.setBackgroundImageSvg("seta-direita"));
            this.btnEntrar.addCss(css.setPosition("relative"));
            this.btnEntrar.addCss(css.setRight(21));
            this.btnEntrar.addCss(css.setTop(14));

            this.tagBody.addCss(css.setColor(AppPicPay.i.objTema.corTextoPrimaria));
            this.tagBody.addCss(css.setTextAlign("center"));

            this.divConteudo.addCss(css.setPosition("absolute"));
            this.divConteudo.addCss(css.setWidth(300));

            this.divLoginInfo.addCss(css.setDisplayNone());
            this.divLoginInfo.addCss(css.setMarginTop(50));

            this.divLogo.addCss(css.setBackgroundImagePng("favicon"));
            this.divLogo.addCss(css.setBackgroundPosition("center"));
            this.divLogo.addCss(css.setBackgroundRepeat("no-repeat"));
            this.divLogo.addCss(css.setBackgroundSize("100% 100%"));
            this.divLogo.addCss(css.setBackgroundSize("contain"));
            this.divLogo.addCss(css.setBorderRadius(2));
            this.divLogo.addCss(css.setBoxShadow(5, 5, 10, 0, AppWebBase.i.objTema.corPrimariaEscura));
            this.divLogo.addCss(css.setHeight(30, "vh"));
            this.divLogo.addCss(css.setMarginBottom(50));
            this.divLogo.addCss(css.setMarginTop(50));
            this.divLogo.addCss(css.setMinHeight(150));

            this.frmLogin.addCss(css.setPosition("relative"));

            this.txtLogin.addCss(css.setBackgroundColor(AppPicPay.i.objTema.corSecundariaClara));
            this.txtLogin.addCss(css.setBorderBottom(1, "solid", AppPicPay.i.objTema.corSecundaria));
            this.txtLogin.addCss(css.setBorderLeft(0, "solid", AppPicPay.i.objTema.corSecundaria));
            this.txtLogin.addCss(css.setBorderRadius(2));
            this.txtLogin.addCss(css.setBorderRight(0, "solid", AppPicPay.i.objTema.corSecundaria));
            this.txtLogin.addCss(css.setBorderTop(0, "solid", AppPicPay.i.objTema.corSecundaria));
            this.txtLogin.addCss(css.setFontSize(16));
            this.txtLogin.addCss(css.setHeight(40));
            this.txtLogin.addCss(css.setOutline("none"));
            this.txtLogin.addCss(css.setPosition("relative"));
            this.txtLogin.addCss(css.setTextAlign("center"));
            this.txtLogin.addCss(css.setWidth(250));

            this.txtSenha.addCss(this.txtLogin);
            this.txtSenha.addCss(css.setRight(-20));
        }

        protected override void setStrId(string strId)
        {
            base.setStrId(strId);

            this.btnEntrar.strId = Utils.addUnderline(strId, nameof(this.btnEntrar));
            this.divConteudo.strId = Utils.addUnderline(strId, nameof(this.divConteudo));
            this.divLoginInfo.strId = Utils.addUnderline(strId, nameof(this.divLoginInfo));
            this.txtLogin.strId = Utils.addUnderline(strId, nameof(this.txtLogin));
            this.txtSenha.strId = Utils.addUnderline(strId, nameof(this.txtSenha));
        }

        private void inicializarBtnEntrar()
        {
            this.btnEntrar.enmTamanho = BotaoCircular.EnmTamanho.NORMAL;
            this.btnEntrar.strTitle = "Fazer login.";
        }

        private void inicializarTagLinkAppManifest()
        {
            this.tagLinkAppManifest.addAtt("rel", "manifest");
            this.tagLinkAppManifest.addAtt("href", "res/app-manifest.json");
        }

        private void inicializarTxtSenha()
        {
            this.txtSenha.enmTipo = Input.EnmTipo.PASSWORD;
            this.txtSenha.strPlaceHolder = "Senha";
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}