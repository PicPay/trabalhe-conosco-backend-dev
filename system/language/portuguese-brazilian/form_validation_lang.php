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

$lang['form_validation_required'] = 'O campo <strong>{field}</strong> � obrigat�rio.';
$lang['form_validation_isset'] = 'O campo <strong>{field}</strong> deve ter um valor.';
$lang['form_validation_valid_email'] = 'O campo <strong>{field}</strong> deve conter um endere�o de email v�lido.';
$lang['form_validation_valid_emails'] = 'O campo <strong>{field}</strong> deve conter todos os endere�os de emails v�lidos.';
$lang['form_validation_valid_url'] = 'O campo <strong>{field}</strong> deve conter uma URL v�lida.';
$lang['form_validation_valid_ip'] = 'O campo <strong>{field}</strong> deve conter um IP v�lido.';
$lang['form_validation_min_length'] = 'O campo <strong>{field}</strong> deve ter pelo menos <strong>{field}</strong> caracter(es).';
$lang['form_validation_max_length'] = 'O campo <strong>{field}</strong> n�o deve ter mais do que {param} caracter(es).';
$lang['form_validation_exact_length'] = 'O campo <strong>{field}</strong> deve ter exatamente {param} caracter(es).';
$lang['form_validation_alpha'] = 'O campo <strong>{field}</strong> deve conter somente letras.';
$lang['form_validation_alpha_numeric'] = 'O campo <strong>{field}</strong> deve conter somente letras ou n�meros.';
$lang['form_validation_alpha_numeric_spaces'] = 'O campo <strong>{field}</strong> deve conter somente letras, n�meros e espa�os.';
$lang['form_validation_alpha_dash'] = 'O campo <strong>{field}</strong> deve conter somente letras, n�meros, underlines e tra�os.';
$lang['form_validation_numeric'] = 'O campo <strong>{field}</strong> deve conter somente n�meros.';
$lang['form_validation_is_numeric'] = 'O campo <strong>{field}</strong> deve conter somente caracteres n�mericos.';
$lang['form_validation_integer'] = 'O campo <strong>{field}</strong> deve conter um n�mero inteiro.';
$lang['form_validation_regex_match'] = 'O campo <strong>{field}</strong> n�o est� em um formato correto.';
$lang['form_validation_matches'] = 'O campo <strong>{field}</strong> n�o � igual ao campo {param}.';
$lang['form_validation_differs'] = 'O campo <strong>{field}</strong> deve ser diferente do campo {param}.';
$lang['form_validation_is_unique'] = 'O campo <strong>{field}</strong> cont�m um valor j� cadastrado no banco de dados.';
$lang['form_validation_is_natural'] = 'O campo <strong>{field}</strong> deve conter somente n�mero natural.';
$lang['form_validation_is_natural_no_zero'] = 'O campo <strong>{field}</strong> deve conter somente n�mero natural e n�o deve conter o zero.';
$lang['form_validation_decimal'] = 'O campo <strong>{field}</strong> deve conter um n�mero decimal.';
$lang['form_validation_less_than'] = 'O campo <strong>{field}</strong> deve conter um n�mero menor que {param}';
$lang['form_validation_less_than_equal_to'] = 'O campo <strong>{field}</strong> deve conter um n�mero menor ou igual que {param}.';
$lang['form_validation_greater_than'] = 'O campo <strong>{field}</strong> deve conter um n�mero maior que {param}.';
$lang['form_validation_greater_than_equal_to'] = 'O campo <strong>{field}</strong> deve conter um n�mero maior ou igual que {param}.';
$lang['form_validation_error_message_not_set']  = 'N�o existe uma mensagem de erro para o campo com o nome <strong>{field}</strong>.';

/* End of file form_validation_lang.php */
/* Location: ./application/language/portuguese-brazilian/form_validation_lang.php */

$lang['file_required']			= "O campo <strong>%s</strong> � obrigat�rio";
$lang['file_size_max']			= "O arquivo carregado no campo <strong>%s</strong> � muito grande (tamanho m�ximo: <strong>%s</strong>).";
$lang['file_size_min']			= "O arquivo carregado no campo <strong>%s</strong> � muito pequeno (tamanho m�nimo <strong>%s</strong>).";
$lang['file_allowed_type']		= "O arquivo carregado no campo <strong>%s</strong> deve ser no formato <strong>%s</strong>.";
$lang['file_disallowed_type']		= "O arquivo carregado no campo <strong>%s</strong> n�o pode ser no formato <strong>%s</strong>.";
$lang['file_image_maxdim']		= "As dimens�es do arquivo carregado no campo <strong>%s</strong> ultrapassam o limite m�ximo.";
$lang['file_image_mindim']		= "As dimens�es do arquivo carregado no campo <strong>%s</strong> ultrapassam o limite m�nimo.";
$lang['file_image_exactdim']		= "O arquivo carregado no campo <strong>%s</strong> n�o possui as dimens�es permitidas.";
$lang['error_max_filesize_phpini']	= "O arquivo ultrapassa o limite da diretiva <strong>upload_max_filesize</strong> do php.ini.";
$lang['error_max_filesize_form']	= "O arquivo carregado ultrapassa a diretiva <strong>MAX_FILE_SIZE</strong> especificada no formul�rio HTML.";
$lang['error_partial_upload']		= "O arquivo foi carregado parcialmente.";
$lang['error_temp_dir']			= "Erro no diret�rio temp.";
$lang['error_disk_write']		= "Erro de escrita no disco.";
$lang['error_stopped']			= "Carregamento do arquivo interrompido.";
$lang['error_unexpected']		= "Erro de upload inesperado. Erro: <strong>%s</strong>";
