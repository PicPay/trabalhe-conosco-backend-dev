using OWeb.Server.Ajax.Dbe;

namespace PicPay.Server
{
    public sealed class SrvAjaxDbePicPay : SrvAjaxDbeBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private static SrvAjaxDbePicPay _i;

        public static SrvAjaxDbePicPay i
        {
            get
            {
                if (_i != null)
                {
                    return _i;
                }

                _i = new SrvAjaxDbePicPay();

                return _i;
            }
        }

        #endregion Atributos

        #region Construtores

        #endregion Construtores

        #region Métodos

        protected override int getIntPorta()
        {
            return ConfigPicPay.i.intSrvAjaxDbePorta;
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}