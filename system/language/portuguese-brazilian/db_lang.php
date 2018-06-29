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

$lang['db_invalid_connection_str'] = 'Nуo foi possэvel determinar as configuraчѕes do banco de dados baseado na string de conexуo que vocъ submeteu.';
$lang['db_unable_to_connect'] = 'Nуo foi possэvel conectar com seu banco de dados usando as configuraчѕes fornecidas.';
$lang['db_unable_to_select'] = 'Nуo foi possэvel selecionar o banco de dados especificado: %s';
$lang['db_unable_to_create'] = 'Nуo foi possэvel criar o banco de dados especificado: %s';
$lang['db_invalid_query'] = 'A consulta(query) que vocъ submeteu nуo щ vсlida.';
$lang['db_must_set_table'] = 'Vocъ deve configurar a tabela em seu banco de dados para ser usada com sua consulta(query).';
$lang['db_must_use_set'] = 'Vocъ deve usar o mщtodo "set" para atualizar um registro.';
$lang['db_must_use_index'] = 'Vocъ deve especificar um эndice(index) para corresponder com as suas atualizaчѕes em lote.';
$lang['db_batch_missing_index'] = 'Uma ou mais linhas enviadas para atualizaчуo em lote estс faltando o эndice(index) especificado.';
$lang['db_must_use_where'] = 'Atualizaчѕes(Updates) nуo sуo permitidas a menos que exista a clausula "where".';
$lang['db_del_must_use_where'] = 'Exclusѕes(Deletes) nуo sуo permitidos a menos que exista a clausula "where" ou "like".';
$lang['db_field_param_missing'] = 'Para buscar campos requer o nome da tabela como um parтmetro.';
$lang['db_unsupported_function'] = 'Esta funcionalidade nуo estс disponэvel para o banco de dados que vocъ estс usando.';
$lang['db_transaction_failure'] = 'Falha na Transaчуo: Rollback executado.';
$lang['db_unable_to_drop'] = 'Nуo foi possэvel deletar(drop) o banco de dados especificado.';
$lang['db_unsuported_feature'] = 'Funcionalidade nуo suportada no banco de dados que vocъ estс usando.';
$lang['db_unsuported_compression'] = 'O formato de compressуo de arquivo que vocъ escolheu nуo щ suportado pelo seu servidor.';
$lang['db_filepath_error'] = 'Nуo foi possэvel escrever os dados para o arquivo que vocъ enviou.';
$lang['db_invalid_cache_path'] = 'O caminho do cache(cache path) que vocъ enviou nуo щ vсlido ou gravсvel.';
$lang['db_table_name_required'] = 'O nome da tabela щ obrigatѓrio para esta operaчуo.';
$lang['db_column_name_required'] = 'O nome da coluna щ obrigatѓrio para esta operaчуo.';
$lang['db_column_definition_required'] = 'A definiчуo da coluna щ obrigatѓria para esta operaчуo.';
$lang['db_unable_to_set_charset'] = 'Nуo щ possэvel configurar o character set da conexуo cliente: %s';
$lang['db_error_heading'] = 'Um erro no Banco de Dados aconteceu';

/* End of file db_lang.php */
/* Location: ./application/language/portuguese-brazilian/db_lang.php */