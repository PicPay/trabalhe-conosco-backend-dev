using OWeb.Html;
using OWeb.Server.Arquivo.Css;

namespace PicPay.Html.Componente
{
    public class DivRodape : Div
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private Div _divCopyright;

        private Div divCopyright
        {
            get
            {
                if (_divCopyright != null)
                {
                    return _divCopyright;
                }

                _divCopyright = new Div();

                return _divCopyright;
            }
        }

        #endregion Atributos

        #region Construtores

        #endregion Construtores

        #region Métodos

        protected override void inicializar()
        {
            base.inicializar();

            this.divCopyright.strConteudo = string.Format("{0} | © Copyright 2018", AppPicPay.i.strNomeExibicao);
        }

        protected override void montarLayout()
        {
            base.montarLayout();

            this.divCopyright.setPai(this);
        }

        protected override void setCss(CssArquivoBase css)
        {
            base.setCss(css);

            this.addCss(css.setBackgroundColor(AppPicPay.i.objTema.corPrimariaEscura));
            this.addCss(css.setBottom(0));
            this.addCss(css.setLeft(0));
            this.addCss(css.setPosition("absolute"));
            this.addCss(css.setRight(0));
            this.addCss(css.setZIndex(-1));

            this.divCopyright.addCss(css.setColor(AppPicPay.i.objTema.corTextoPrimaria));
            this.divCopyright.addCss(css.setFontSizeSmall());
            this.divCopyright.addCss(css.setLineHeight(30));
            this.divCopyright.addCss(css.setMarginRight(10));
            this.divCopyright.addCss(css.setTextAlign("center"));
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}