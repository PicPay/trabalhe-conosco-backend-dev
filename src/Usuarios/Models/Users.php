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
 * ),
 * @OA\Server(
 *			url="http://trabalho.localhost/",
 *			description="Homologação"
 *	   )
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

	public function getUsers($name)
	{

		try {
		    $dbh = new \PDO('mysql:host=localhost;dbname=picpay', 'root', '');
		} catch (\PDOException $e) {
		    error_log($e->getMessage());
		}

		try {
			$stm = $dbh->prepare('SELECT users.* from picpay.users LEFT JOIN picpay.users_priority
									ON users.id = users_priority.id 
									WHERE nome LIKE :nome OR username LIKE :nome 
									ORDER BY users_priority.priority DESC
									LIMIT 15');

			$stm->bindValue(":nome","%".$name."%", \PDO::PARAM_STR);

			if($stm->execute()) {
				return $stm->fetchAll(\PDO::FETCH_OBJ);
			}
		} catch (Exception $e) {
			error_log($e->getMessage());
		}

		return false;
	}
}