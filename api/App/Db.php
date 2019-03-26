<?php

/**
 * Class Db
 *
 * Classe baseada na classe PDO aprimorando a segurança contra SQL Injection também uma forma mais facilidata
 * de interagir com um banco de dados
 *
 * @package App\
 *
 * @author Marcos Angelo Molizane <marcos@molizane.com>
 * @version 1.0.0
 */
class Db
{
    private $host = '172.17.0.1';   // for docker environment
    // private $host = 'localhost'; // for local/server environment
    private $db   = 'picpay';
    private $user = 'root';
    private $pass = 'root';
    private $charset = 'utf8mb4';
    private $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // erros são retornados como exceção
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // os resultados serão formatados como um array associativo
        PDO::ATTR_EMULATE_PREPARES   => false,                  // desliga o emulation mode
    ];
    private $res_con = "";   // armazena a connection string
    public $res_pdo = null;  // armazena o recurso PDO após uma conexão bem sucedida
    public $return = "";     // armazena possíveis mensagens de erros de conexão

    public function __construct()
    {
        $this->res_con = vsprintf("mysql:host=%s;dbname=%s;charset=%s", [$this->host, $this->db, $this->charset]);
        try {
            $this->res_pdo = new PDO($this->res_con, $this->user, $this->pass, $this->options);
        } catch (\PDOException $e) {
            $this->return = vsprintf("ERROR: (%s) %s", [$e->getCode(), $e->getMessage()]);
        }
    }
}
