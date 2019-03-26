<?php

require_once ROOT . '/Model/DbModel.php';

/**
 * Class UserModel
 *
 * Retém detalhes da tabela uf também como regras de validações dos campos visíveis
 *
 * @package Model\
 * @see Model\DbModel
 *
 * @author Marcos Angelo Molizane <marcos@molizane.com>
 * @version 1.0.0
 */
class UserModel extends DbModel
{
    // nome da tabela no banco de dados
    public $str_table_name = 'users';
    // Armazena os nomes dos campos na tabela e em tela (nome_tabela => 'Nome na Tela')
    public $arr_table_fields = [
        'uuid' => 'UUID',
        'nome' => 'Nome',
        'username' => 'Username'
    ];
    // Armazena as regras de validação para o modelo de dados
    public $arr_validation_rules = [
        'id' => 'mandatory|string|:36',
        'nome' => 'mandatory|:60',
        'username' => 'mandatory|:60'
    ];
    // Armazena campos indexados como fulltext
    public $arr_table_fields_fulltext = ['nome', 'username', 'uuid'];
    // Armazena a ordem dos campos na busca
    public $arr_table_fields_order = ['`nome`', '`username`', '`id`'];
    // Tamanho da paginação
    public $int_pagesize = 15;
}