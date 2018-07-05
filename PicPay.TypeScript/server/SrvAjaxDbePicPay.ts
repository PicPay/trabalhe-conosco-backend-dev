// #region Reference

/// <reference path="../../OWeb.TypeScript/ConstanteManager.ts"/>
/// <reference path="../../OWeb.TypeScript/server/ajax/dbe/SrvAjaxDbeBase.ts"/>

// #endregion Reference

module PicPay
{
    // #region Importações

    import ConstanteManager = OWeb.ConstanteManager;
    import SrvAjaxDbeBase = OWeb.SrvAjaxDbeBase;

    // #endregion Importações

    // #region Enumerados
    // #endregion Enumerados

    export class SrvAjaxDbePicPay extends SrvAjaxDbeBase
    {
        // #region Constantes

        // #endregion Constantes

        // #region Atributos

        // #endregion Atributos

        // #region Construtores

        // #endregion Construtores

        // #region Métodos

        protected getIntPorta(): number
        {
            return ConstanteManager.i.getIntConstante(SrvAjaxDbePicPay.name + "_porta");
        }

        // #endregion Métodos

        // #region Eventos
        // #endregion Eventos
    }
}