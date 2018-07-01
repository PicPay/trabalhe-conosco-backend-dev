<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['db_invalid_connection_str'] = 'N�o foi poss�vel determinar as configura��es do banco de dados baseado na string de conex�o que voc� submeteu.';
$lang['db_unable_to_connect'] = 'N�o foi poss�vel conectar com seu banco de dados usando as configura��es fornecidas.';
$lang['db_unable_to_select'] = 'N�o foi poss�vel selecionar o banco de dados especificado: %s';
$lang['db_unable_to_create'] = 'N�o foi poss�vel criar o banco de dados especificado: %s';
$lang['db_invalid_query'] = 'A consulta(query) que voc� submeteu n�o � v�lida.';
$lang['db_must_set_table'] = 'Voc� deve configurar a tabela em seu banco de dados para ser usada com sua consulta(query).';
$lang['db_must_use_set'] = 'Voc� deve usar o m�todo "set" para atualizar um registro.';
$lang['db_must_use_index'] = 'Voc� deve especificar um �ndice(index) para corresponder com as suas atualiza��es em lote.';
$lang['db_batch_missing_index'] = 'Uma ou mais linhas enviadas para atualiza��o em lote est� faltando o �ndice(index) especificado.';
$lang['db_must_use_where'] = 'Atualiza��es(Updates) n�o s�o permitidas a menos que exista a clausula "where".';
$lang['db_del_must_use_where'] = 'Exclus�es(Deletes) n�o s�o permitidos a menos que exista a clausula "where" ou "like".';
$lang['db_field_param_missing'] = 'Para buscar campos requer o nome da tabela como um par�metro.';
$lang['db_unsupported_function'] = 'Esta funcionalidade n�o est� dispon�vel para o banco de dados que voc� est� usando.';
$lang['db_transaction_failure'] = 'Falha na Transa��o: Rollback executado.';
$lang['db_unable_to_drop'] = 'N�o foi poss�vel deletar(drop) o banco de dados especificado.';
$lang['db_unsuported_feature'] = 'Funcionalidade n�o suportada no banco de dados que voc� est� usando.';
$lang['db_unsuported_compression'] = 'O formato de compress�o de arquivo que voc� escolheu n�o � suportado pelo seu servidor.';
$lang['db_filepath_error'] = 'N�o foi poss�vel escrever os dados para o arquivo que voc� enviou.';
$lang['db_invalid_cache_path'] = 'O caminho do cache(cache path) que voc� enviou n�o � v�lido ou grav�vel.';
$lang['db_table_name_required'] = 'O nome da tabela � obrigat�rio para esta opera��o.';
$lang['db_column_name_required'] = 'O nome da coluna � obrigat�rio para esta opera��o.';
$lang['db_column_definition_required'] = 'A defini��o da coluna � obrigat�ria para esta opera��o.';
$lang['db_unable_to_set_charset'] = 'N�o � poss�vel configurar o character set da conex�o cliente: %s';
$lang['db_error_heading'] = 'Um erro no Banco de Dados aconteceu';

/* End of file db_lang.php */
/* Location: ./application/language/portuguese-brazilian/db_lang.php */