using OWeb.DataBase.Tabela;

namespace PicPay.DataBase
{
    internal class TblUsuario : TblUsuarioBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private static TblUsuario _i;

        public new static TblUsuario i
        {
            get
            {
                if (_i != null)
                {
                    return _i;
                }

                _i = new TblUsuario();

                return _i;
            }
        }

        #endregion Atributos

        #region Construtores

        private TblUsuario()
        {
        }

        #endregion Construtores

        #region Métodos

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}