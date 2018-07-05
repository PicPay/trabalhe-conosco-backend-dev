using OWeb;
using OWeb.Html.Componente.Campo;
using OWeb.Html.Componente.Janela.Cadastro;
using PicPay.DataBase;

namespace PicPay.Html.Componente.Janela
{
    [HtmlExport]
    internal class JnlUsuarioCadastro : JnlCadastroBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private CampoAlfanumerico _cmpStrLogin;
        private CampoSenha _cmpStrSenha;

        private CampoAlfanumerico cmpStrLogin
        {
            get
            {
                if (_cmpStrLogin != null)
                {
                    return _cmpStrLogin;
                }

                _cmpStrLogin = new CampoAlfanumerico();

                return _cmpStrLogin;
            }
        }

        private CampoSenha cmpStrSenha
        {
            get
            {
                if (_cmpStrSenha != null)
                {
                    return _cmpStrSenha;
                }

                _cmpStrSenha = new CampoSenha();

                return _cmpStrSenha;
            }
        }

        #endregion Atributos

        #region Construtores

        public JnlUsuarioCadastro() : base(TblUsuario.i)
        {
        }

        #endregion Construtores

        #region Métodos

        protected override void inicializar()
        {
            base.inicializar();

            this.cmpStrLogin.intNivel = 1;

            this.cmpStrSenha.intNivel = 2;
        }

        protected override void montarLayout()
        {
            base.montarLayout();

            this.cmpStrLogin.setPai(this);

            this.cmpStrSenha.setPai(this);
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}