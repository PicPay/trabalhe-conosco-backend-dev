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

$lang['form_validation_required'] = 'O campo <strong>{field}</strong> é obrigatório.';
$lang['form_validation_isset'] = 'O campo <strong>{field}</strong> deve ter um valor.';
$lang['form_validation_valid_email'] = 'O campo <strong>{field}</strong> deve conter um endereço de email válido.';
$lang['form_validation_valid_emails'] = 'O campo <strong>{field}</strong> deve conter todos os endereços de emails válidos.';
$lang['form_validation_valid_url'] = 'O campo <strong>{field}</strong> deve conter uma URL válida.';
$lang['form_validation_valid_ip'] = 'O campo <strong>{field}</strong> deve conter um IP válido.';
$lang['form_validation_min_length'] = 'O campo <strong>{field}</strong> deve ter pelo menos <strong>{field}</strong> caracter(es).';
$lang['form_validation_max_length'] = 'O campo <strong>{field}</strong> não deve ter mais do que {param} caracter(es).';
$lang['form_validation_exact_length'] = 'O campo <strong>{field}</strong> deve ter exatamente {param} caracter(es).';
$lang['form_validation_alpha'] = 'O campo <strong>{field}</strong> deve conter somente letras.';
$lang['form_validation_alpha_numeric'] = 'O campo <strong>{field}</strong> deve conter somente letras ou números.';
$lang['form_validation_alpha_numeric_spaces'] = 'O campo <strong>{field}</strong> deve conter somente letras, números e espaços.';
$lang['form_validation_alpha_dash'] = 'O campo <strong>{field}</strong> deve conter somente letras, números, underlines e traços.';
$lang['form_validation_numeric'] = 'O campo <strong>{field}</strong> deve conter somente números.';
$lang['form_validation_is_numeric'] = 'O campo <strong>{field}</strong> deve conter somente caracteres númericos.';
$lang['form_validation_integer'] = 'O campo <strong>{field}</strong> deve conter um número inteiro.';
$lang['form_validation_regex_match'] = 'O campo <strong>{field}</strong> não está em um formato correto.';
$lang['form_validation_matches'] = 'O campo <strong>{field}</strong> não é igual ao campo {param}.';
$lang['form_validation_differs'] = 'O campo <strong>{field}</strong> deve ser diferente do campo {param}.';
$lang['form_validation_is_unique'] = 'O campo <strong>{field}</strong> contém um valor já cadastrado no banco de dados.';
$lang['form_validation_is_natural'] = 'O campo <strong>{field}</strong> deve conter somente número natural.';
$lang['form_validation_is_natural_no_zero'] = 'O campo <strong>{field}</strong> deve conter somente número natural e não deve conter o zero.';
$lang['form_validation_decimal'] = 'O campo <strong>{field}</strong> deve conter um número decimal.';
$lang['form_validation_less_than'] = 'O campo <strong>{field}</strong> deve conter um número menor que {param}';
$lang['form_validation_less_than_equal_to'] = 'O campo <strong>{field}</strong> deve conter um número menor ou igual que {param}.';
$lang['form_validation_greater_than'] = 'O campo <strong>{field}</strong> deve conter um número maior que {param}.';
$lang['form_validation_greater_than_equal_to'] = 'O campo <strong>{field}</strong> deve conter um número maior ou igual que {param}.';
$lang['form_validation_error_message_not_set']  = 'Não existe uma mensagem de erro para o campo com o nome <strong>{field}</strong>.';

/* End of file form_validation_lang.php */
/* Location: ./application/language/portuguese-brazilian/form_validation_lang.php */

$lang['file_required']			= "O campo <strong>%s</strong> é obrigatório";
$lang['file_size_max']			= "O arquivo carregado no campo <strong>%s</strong> é muito grande (tamanho máximo: <strong>%s</strong>).";
$lang['file_size_min']			= "O arquivo carregado no campo <strong>%s</strong> é muito pequeno (tamanho mínimo <strong>%s</strong>).";
$lang['file_allowed_type']		= "O arquivo carregado no campo <strong>%s</strong> deve ser no formato <strong>%s</strong>.";
$lang['file_disallowed_type']		= "O arquivo carregado no campo <strong>%s</strong> não pode ser no formato <strong>%s</strong>.";
$lang['file_image_maxdim']		= "As dimensões do arquivo carregado no campo <strong>%s</strong> ultrapassam o limite máximo.";
$lang['file_image_mindim']		= "As dimensões do arquivo carregado no campo <strong>%s</strong> ultrapassam o limite mínimo.";
$lang['file_image_exactdim']		= "O arquivo carregado no campo <strong>%s</strong> não possui as dimensões permitidas.";
$lang['error_max_filesize_phpini']	= "O arquivo ultrapassa o limite da diretiva <strong>upload_max_filesize</strong> do php.ini.";
$lang['error_max_filesize_form']	= "O arquivo carregado ultrapassa a diretiva <strong>MAX_FILE_SIZE</strong> especificada no formulário HTML.";
$lang['error_partial_upload']		= "O arquivo foi carregado parcialmente.";
$lang['error_temp_dir']			= "Erro no diretório temp.";
$lang['error_disk_write']		= "Erro de escrita no disco.";
$lang['error_stopped']			= "Carregamento do arquivo interrompido.";
$lang['error_unexpected']		= "Erro de upload inesperado. Erro: <strong>%s</strong>";
