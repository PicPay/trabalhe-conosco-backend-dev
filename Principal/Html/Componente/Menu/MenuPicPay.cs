using OBase;
using OWeb.Html;
using OWeb.Html.Componente.Menu;
using OWeb.Server.Arquivo.Css;
using PicPay.Html.Componente.Janela;

namespace PicPay.Html.Componente.Menu
{
    internal class MenuPicPay : MenuBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private Div _divLogo;
        private MenuItemTabela _mniPessoa;
        private MenuItem _mniSair;

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

        private MenuItemTabela mniPessoa
        {
            get
            {
                if (_mniPessoa != null)
                {
                    return _mniPessoa;
                }

                _mniPessoa = new MenuItemTabela(typeof(JnlPessoaConsulta), typeof(JnlPessoaCadastro));

                return _mniPessoa;
            }
        }

        private MenuItem mniSair
        {
            get
            {
                if (_mniSair != null)
                {
                    return _mniSair;
                }

                _mniSair = new MenuItem();

                return _mniSair;
            }
        }

        #endregion Atributos

        #region Construtores

        #endregion Construtores

        #region Métodos

        protected override void inicializar()
        {
            base.inicializar();

            this.mniSair.divTitulo.strConteudo = "Sair";
        }

        protected override void montarLayout()
        {
            base.montarLayout();

            this.divLogo.setPai(this.divCabecalho);

            this.mniPessoa.setPai(this);

            this.mniSair.setPai(this);
        }

        protected override void setCss(CssArquivoBase css)
        {
            base.setCss(css);

            this.divCabecalho.addCss(css.setHeight(225));

            this.divLogo.addCss(css.setBackgroundImagePng("favicon"));
            this.divLogo.addCss(css.setBackgroundPosition("center"));
            this.divLogo.addCss(css.setBackgroundSize(100, "%"));
            this.divLogo.addCss(css.setHeight(100, "%"));

            this.divPesquisaConteudo.addCss(css.setDisplayNone());

            this.mniPessoa.divIcone.addCss(css.setBackgroundImageSvg("pessoa"));

            this.mniSair.divIcone.addCss(css.setBackgroundImageSvg("shutdown"));
        }

        protected override void setStrId(string strId)
        {
            base.setStrId(strId);

            this.mniSair.strId = Utils.addUnderline(strId, nameof(this.mniSair));
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}