<?php

namespace Usuarios\Models;

/**
 * Class Users
 *
 *
 * @author  Giancarlo Bacci <giancarlo.baci@gmail.com>
 *
 * @OA\Schema(
  *     description="Aqui estão todas as especificações de Usuários",
 *     title="Usuários"
 * )
 */
class Users
{
	/**
	 * @OA\Property(
	 *     format="int32",
	 *     description="Identificador do Usuário.",
	 *     title="ID",
	 *     example=123
	 * )
	 *
	 * @var integer
	 */
	private $id;
	
	/**
	 * @OA\Property(
	 *     description="Nome do Usuário. (Quando possuir)",
	 *     title="name",
	 *     example="John Doe"
	 * )
	 *
	 * @var string
	 */
	private $name;
	
	/**
	 * @OA\Property(
	 *     description="Login do usuário",
	 *     title="username",
	 *     example="john.doe"
	 * )
	 *
	 * @var string
	 */
	private $username;

	public function getUsers()
	{

		try {
		    $dbh = new \PDO('mysql:host=localhost;dbname=picpay', 'root', '');
		} catch (\PDOException $e) {
		    error_log($e->getMessage());
		    
		}

		$stm = $dbh->prepare('SELECT * from users LIMIT 10');

		if($stm->execute()) {
			return $stm->fetchAll(\PDO::FETCH_OBJ);
		}

		return false;
	}
}