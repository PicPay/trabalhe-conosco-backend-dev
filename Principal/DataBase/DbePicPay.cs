using OData;
using OWeb.DataBase;
using System;
using System.Collections.Generic;

namespace PicPay.DataBase
{
    internal class DbePicPay : DbeWebBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private static DbePicPay _i;

        public static DbePicPay i
        {
            get
            {
                if (_i != null)
                {
                    return _i;
                }

                _i = new DbePicPay();

                return _i;
            }
        }

        #endregion Atributos

        #region Construtores

        private DbePicPay()
        {
        }

        #endregion Construtores

        #region Métodos

        public override TabelaBase getTblUsuario()
        {
            return TblUsuario.i;
        }

        protected override int getIntVersao()
        {
            return -1;
        }

        protected override string getStrDataBase()
        {
            return AppPicPay.i.strNomeSimplificado;
        }

        protected override string getStrHost()
        {
            if (AppPicPay.i.booDocker)
            {
                return Environment.GetEnvironmentVariable("PICPAY_DB_HOST");
            }
            else
            {
                return "localhost";
            }
        }

        protected override string getStrUsuarioLogin()
        {
            return this.strDataBase;
        }

        protected override string getStrUsuarioSenha()
        {
            return "183729";
        }

        protected override void inicializarEstrutura()
        {
            base.inicializarEstrutura();

            TblPessoa.i.inserirRegistro();
        }

        protected override void inicializarLstTbl(List<TabelaBase> lstTbl)
        {
            base.inicializarLstTbl(lstTbl);

            lstTbl.Add(TblPessoa.i);
            lstTbl.Add(TblUsuario.i);
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}