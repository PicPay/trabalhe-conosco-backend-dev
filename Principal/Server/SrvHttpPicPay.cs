using OWeb;
using OWeb.Server;
using PicPay.Html.Pagina;
using System.Collections.Generic;
using System.Reflection;

namespace PicPay.Server
{
    internal class SrvHttpPicPay : SrvHttpBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        #endregion Atributos

        #region Construtores

        #endregion Construtores

        #region Métodos

        public override Resposta responder(Solicitacao objSolicitacao)
        {
            return base.responder(objSolicitacao) ?? this.responderLocal(objSolicitacao);
        }

        protected override int getIntPorta()
        {
            return ConfigPicPay.i.intSrvHttpPorta;
        }

        protected override UiExportBase getObjUiManager()
        {
            return new UiExport();
        }

        private Resposta responderLocal(Solicitacao objSolicitacao)
        {
            if (objSolicitacao == null)
            {
                return null;
            }

            if ((objSolicitacao.strPagina?.Equals("/login") ?? true) && (!objSolicitacao.objUsuario?.booLogado ?? true))
            {
                return this.responderPagEstatica(objSolicitacao, typeof(PagLoginPicPay));
            }

            if ((objSolicitacao.objUsuario?.booLogado ?? false) && (objSolicitacao.strPagina?.Equals("/") ?? false))
            {
                return this.responderPagEstatica(objSolicitacao, typeof(PagPrincipalPicPay));
            }

            var objResposta = new Resposta(objSolicitacao);

            if (!objSolicitacao.objUsuario?.booLogado ?? true)
            {
                return new Resposta(objSolicitacao).redirecionarTemporario("/login");
            }
            else
            {
                return new Resposta(objSolicitacao).redirecionarTemporario("/");
            }
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }

    internal class UiExport : UiExportBase
    {
        #region Métodos

        protected override void inicializarLstDllUi(List<Assembly> lstDllUi)
        {
            base.inicializarLstDllUi(lstDllUi);

            lstDllUi.Add(this.GetType().Assembly);
        }

        #endregion Métodos
    }
}