using OBase;
using OBase.Servico;
using OData;
using OWeb;
using PicPay.DataBase;
using PicPay.Server;
using System;
using System.Collections.Generic;

namespace PicPay
{
    internal class AppPicPay : AppWebBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private static AppPicPay _i;

        public new static AppPicPay i
        {
            get
            {
                if (_i != null)
                {
                    return _i;
                }

                _i = new AppPicPay();

                return _i;
            }
        }

        #endregion Atributos

        #region Construtores

        private AppPicPay()
        {
        }

        #endregion Construtores

        #region Métodos

        protected override ConfigBase getCfg()
        {
            return ConfigPicPay.i;
        }

        protected override DbeBase getDbe()
        {
            return DbePicPay.i;
        }

        protected override TemaBase getObjTema()
        {
            return new TemaPicPay();
        }

        protected override void inicializarLstSrv(List<ServicoBase> lstSrv)
        {
            lstSrv.Add(new SrvAjaxDbePicPay());
            lstSrv.Add(new SrvHttpPicPay());
        }

        protected override void inicializarLstStrConsoleLogo(List<string> lstStrConsoleLogo)
        {
            base.inicializarLstStrConsoleLogo(lstStrConsoleLogo);

            lstStrConsoleLogo.Add(@"______ _     ______           ");
            lstStrConsoleLogo.Add(@"| ___ (_)    | ___ \          ");
            lstStrConsoleLogo.Add(@"| |_/ /_  ___| |_/ /_ _ _   _ ");
            lstStrConsoleLogo.Add(@"|  __/| |/ __|  __/ _` | | | |");
            lstStrConsoleLogo.Add(@"| |   | | (__| | | (_| | |_| |");
            lstStrConsoleLogo.Add(@"\_|   |_|\___\_|  \__,_|\__, |");
            lstStrConsoleLogo.Add(@"===========================/ |");
            lstStrConsoleLogo.Add(@"                        |___/ ");
        }

        [STAThread]
        private static void Main(string[] arrStrParam)
        {
            i.iniciarConsole();
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}