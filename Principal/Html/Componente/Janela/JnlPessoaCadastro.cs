using OWeb;
using OWeb.Html.Componente.Campo;
using OWeb.Html.Componente.Janela.Cadastro;
using PicPay.DataBase;

namespace PicPay.Html.Componente.Janela
{
    [HtmlExport]
    internal class JnlPessoaCadastro : JnlCadastroBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private CampoComboBox _cmpEnmPrioridade;
        private CampoAlfanumerico _cmpStrHash;
        private CampoAlfanumerico _cmpStrNome;
        private CampoAlfanumerico _cmpStrUserName;

        private CampoComboBox cmpEnmPrioridade
        {
            get
            {
                if (_cmpEnmPrioridade != null)
                {
                    return _cmpEnmPrioridade;
                }

                _cmpEnmPrioridade = new CampoComboBox();

                return _cmpEnmPrioridade;
            }
        }

        private CampoAlfanumerico cmpStrHash
        {
            get
            {
                if (_cmpStrHash != null)
                {
                    return _cmpStrHash;
                }

                _cmpStrHash = new CampoAlfanumerico();

                return _cmpStrHash;
            }
        }

        private CampoAlfanumerico cmpStrNome
        {
            get
            {
                if (_cmpStrNome != null)
                {
                    return _cmpStrNome;
                }

                _cmpStrNome = new CampoAlfanumerico();

                return _cmpStrNome;
            }
        }

        private CampoAlfanumerico cmpStrUserName
        {
            get
            {
                if (_cmpStrUserName != null)
                {
                    return _cmpStrUserName;
                }

                _cmpStrUserName = new CampoAlfanumerico();

                return _cmpStrUserName;
            }
        }

        #endregion Atributos

        #region Construtores

        public JnlPessoaCadastro() : base(TblPessoa.i)
        {
        }

        #endregion Construtores

        #region Métodos

        protected override void inicializar()
        {
            base.inicializar();

            this.cmpStrNome.enmTamanho = CampoHtmlBase.EnmTamanho.EXTRA;
            this.cmpStrNome.intNivel = 1;

            this.cmpStrUserName.intNivel = 2;

            this.cmpStrHash.intNivel = 2;

            this.cmpEnmPrioridade.intNivel = 3;
        }

        protected override void montarLayout()
        {
            base.montarLayout();

            this.cmpStrNome.setPai(this);

            this.cmpStrUserName.setPai(this);

            this.cmpStrHash.setPai(this);

            this.cmpEnmPrioridade.setPai(this);
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}