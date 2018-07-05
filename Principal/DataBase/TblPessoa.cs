using OData;
using System.Collections.Generic;
using System.IO;

namespace PicPay.DataBase
{
    internal class TblPessoa : TabelaBase
    {
        #region Constantes

        #endregion Constantes

        #region Atributos

        private static TblPessoa _i;

        private Coluna _clnEnmPrioridade;
        private Coluna _clnStrHash;
        private Coluna _clnStrNome;
        private Coluna _clnStrUserName;

        public static TblPessoa i
        {
            get
            {
                if (_i != null)
                {
                    return _i;
                }

                _i = new TblPessoa();

                return _i;
            }
        }

        private Coluna clnEnmPrioridade
        {
            get
            {
                if (_clnEnmPrioridade != null)
                {
                    return _clnEnmPrioridade;
                }

                _clnEnmPrioridade = new Coluna("enm_prioridade", Coluna.EnmTipo.SMALLINT);

                return _clnEnmPrioridade;
            }
        }

        private Coluna clnStrHash
        {
            get
            {
                if (_clnStrHash != null)
                {
                    return _clnStrHash;
                }

                _clnStrHash = new Coluna("str_hash", Coluna.EnmTipo.TEXT);

                return _clnStrHash;
            }
        }

        private Coluna clnStrNome
        {
            get
            {
                if (_clnStrNome != null)
                {
                    return _clnStrNome;
                }

                _clnStrNome = new Coluna("str_nome", Coluna.EnmTipo.TEXT);

                return _clnStrNome;
            }
        }

        private Coluna clnStrUserName
        {
            get
            {
                if (_clnStrUserName != null)
                {
                    return _clnStrUserName;
                }

                _clnStrUserName = new Coluna("str_user_name", Coluna.EnmTipo.TEXT);

                return _clnStrUserName;
            }
        }

        #endregion Atributos

        #region Construtores

        private TblPessoa()
        {
        }

        #endregion Construtores

        #region Métodos

        internal void inserirRegistro()
        {
            return;

            //if (!this.booRecemCriada)
            //{
            //    return;
            //}

            //Log.i.info("Inserindo os registros na tabela \"{0}\".", this.sqlNome);

            //this.inserirRegistroArquivo();

            //Log.i.info("Atualizando a prioridade dos registros da tabela \"{0}\".", this.sqlNome);

            //this.dbe.execSql(Resources.Update.update_lista_relevancia_1);

            //this.dbe.execSql(Resources.Update.update_lista_relevancia_2);
        }

        protected override void inicializar()
        {
            base.inicializar();

            this.clnBooAtivo.booVisivelConsulta = false;
            this.clnBooExcluido.booVisivelConsulta = false;
            this.clnDttAlteracao.booVisivelConsulta = false;
            this.clnDttCadastro.booVisivelConsulta = false;
            this.clnDttExclusao.booVisivelConsulta = false;
            this.clnIntUsuarioAlteracaoId.booVisivelConsulta = false;
            this.clnIntUsuarioCadastroId.booVisivelConsulta = false;
            this.clnIntUsuarioExclusaoId.booVisivelConsulta = false;
            this.clnStrNome.booObrigatorio = true;
            this.clnStrObservacao.booVisivelConsulta = false;
            this.clnStrTag.booVisivelConsulta = false;

            this.inicializarClnEnmPrioridade();

            this.inicializarOrdem();
        }

        protected override void inicializarLstCln(List<Coluna> lstCln)
        {
            base.inicializarLstCln(lstCln);

            lstCln.Add(this.clnEnmPrioridade);
            lstCln.Add(this.clnStrHash);
            lstCln.Add(this.clnStrNome);
            lstCln.Add(this.clnStrUserName);
        }

        private void inicializarClnEnmPrioridade()
        {
            this.clnEnmPrioridade.intOrdem = 500;
            this.clnEnmPrioridade.intValorDefault = 0;

            this.clnEnmPrioridade.addOpcao(0, "Zero (mínima)");
            this.clnEnmPrioridade.addOpcao(2, "Dois (Alta)");
            this.clnEnmPrioridade.addOpcao(3, "Um (Máxima)");
        }

        private void inicializarOrdem()
        {
            this.clnEnmPrioridade.enmOrdem = Coluna.EnmOrdem.DECRESCENTE;

            this.clnStrNome.enmOrdem = Coluna.EnmOrdem.CRESCENTE;
        }

        private void inserirRegistroArquivo()
        {
            foreach (string strLinha in File.ReadLines(string.Format("/app/res/csv/users.csv")))
            {
                this.inserirRegistroArquivo(strLinha);
            }
        }

        private void inserirRegistroArquivo(string strLinha)
        {
            var arrStrLinhaParte = strLinha.Split(',');

            if (arrStrLinhaParte?.Length < 3)
            {
                return;
            }

            var lstClnValor = new List<ClnValor>();
            var strHash = arrStrLinhaParte[0];
            var strNome = arrStrLinhaParte[1];
            var strUserName = arrStrLinhaParte[2];

            lstClnValor.Add(new ClnValor(this.clnStrHash, strHash));
            lstClnValor.Add(new ClnValor(this.clnStrNome, strNome));
            lstClnValor.Add(new ClnValor(this.clnStrUserName, strUserName));

            this.insert(lstClnValor);
        }

        #endregion Métodos

        #region Eventos

        #endregion Eventos
    }
}