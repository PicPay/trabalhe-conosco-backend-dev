using OBase;

namespace PicPay
{
    internal class ConfigPicPay : ConfigBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private static ConfigPicPay _i;

        private int _intDataBaseVersao;
        private int _intSrvAjaxDbePorta = 8080;
        private int _intSrvHttpPorta = 80;

        public static ConfigPicPay i
        {
            get
            {
                if (_i != null)
                {
                    return _i;
                }

                _i = new ConfigPicPay();

                return _i;
            }
        }

        public int intDataBaseVersao
        {
            get
            {
                return _intDataBaseVersao;
            }

            set
            {
                _intDataBaseVersao = value;
            }
        }

        public int intSrvAjaxDbePorta
        {
            get
            {
                return _intSrvAjaxDbePorta;
            }

            set
            {
                _intSrvAjaxDbePorta = value;
            }
        }

        public int intSrvHttpPorta
        {
            get
            {
                return _intSrvHttpPorta;
            }

            set
            {
                _intSrvHttpPorta = value;
            }
        }

        #endregion Atributos

        #region Construtores

        private ConfigPicPay()
        {
        }

        #endregion Construtores

        #region Métodos

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}