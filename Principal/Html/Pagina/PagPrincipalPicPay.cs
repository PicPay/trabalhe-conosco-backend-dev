using OWeb;
using OWeb.DataBase.Dominio;
using OWeb.Html;
using OWeb.Html.Componente.Menu;
using OWeb.Html.Pagina;
using OWeb.Server.Ajax;
using OWeb.Server.Ajax.Dbe;
using OWeb.Server.Arquivo.Css;
using OWeb.Server.WebSocket;
using PicPay.Html.Componente;
using PicPay.Html.Componente.Menu;
using PicPay.Server;

namespace PicPay.Html.Pagina
{
    [HtmlExport]
    public class PagPrincipalPicPay : PagPrincipalBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        #endregion Atributos

        #region Construtores

        public PagPrincipalPicPay() : base("PicPay")
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
            lstJs.Add(new JavaScriptTag(typeof(DominioWebBase), 250));
            lstJs.Add(new JavaScriptTag(typeof(SrvAjaxBase)));
            lstJs.Add(new JavaScriptTag(typeof(SrvAjaxDbeBase), 201));
            lstJs.Add(new JavaScriptTag(typeof(SrvAjaxDbePicPay), 250));
            lstJs.Add(new JavaScriptTag(typeof(SrvHttpPicPay), 250));
            lstJs.Add(new JavaScriptTag(typeof(SrvWsBase)));
            lstJs.Add(new JavaScriptTag(typeof(TemaPicPay), 250));
        }

        protected override bool getBooJsAutoInicializavel()
        {
            return true;
        }

        protected override MenuBase getMnu()
        {
            return new MenuPicPay();
        }

        protected override void montarLayout()
        {
            base.montarLayout();

            new DivRodape().setPai(this);
        }

        protected override void setCss(CssArquivoBase css)
        {
            base.setCss(css);

            this.addCss(css.setBackgroundAttachment("fixed"));
            this.addCss(css.setBackgroundImageJpg("home-skate-bg"));
            this.addCss(css.setBackgroundPosition("center"));
            this.addCss(css.setBackgroundRepeat("no-repeat"));
            this.addCss(css.setBackgroundSize("cover"));
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}