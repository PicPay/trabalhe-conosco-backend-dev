<?php

namespace Usuarios\Controllers;

use Usuarios\Models\Users;

/**
 * @OA\Info(
 *     title="Documentação de API de Usuários",
 *     version="0.0.9",
 *     description="Aqui estão todas as especificações de API de Usuários",
 *     contact={
 *      "name":"Giancarlo Bacci",
 *      "email":"giancarlo.baci@gmail.com"
 *     },
 *     x={
 *          "logo":{
 *              "url":"https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png",
 *              "altText":"PicPay"
 *          }
 *     } 
 * )
 */

class UsersController
{
	/**
	 * @OA\Get(
	 *   path="/users/findByName/{name}",
	 *   description="Esta API retorna o cliente de acordo com a palavra-chave enviada.",
	 *   operationId="findByName",
	 *   tags={"Users"},
	 *   @OA\Parameter(name="name",
	 *     in="path",
	 *     required=true,
	 *     description="Palavra-chave do cliente",
	 *     @OA\Schema(type="string")
	 *   ),
	 *   @OA\Response(response="200",
	 *     description="Retorna o Usuário",
	 *     @OA\JsonContent(ref="#/components/schemas/Users")
	 *   ),
	 *   @OA\Response(response="404",
	 *     description="Usuário não encontrado",
	 *     @OA\JsonContent(ref="#/components/schemas/UsersError")
	 *   ),
	 *   @OA\Response(response="500",
	 *     description="Erro ao resgatar o Usuário",
	 *     @OA\JsonContent(ref="#/components/schemas/UsersError")
	 *   )
	 * )
	 */
	
	public function findByName($name) {
		
		$b = new Users();

		return array("name" => $name, "users" => $b->getUsers($name));
	}
}