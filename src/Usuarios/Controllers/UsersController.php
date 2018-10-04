<?php

namespace Usuarios\Controllers;

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
		
		for($i=1;$i<5;$i++) {
			$a = new \StdClass();
			$a->id = $i;
			$a->name = "Teste ".$i;
			$a->username = "teste.teste".$i;

			$b[] = $a;
		}


		return array("name" => $name, "users" => $b);
	}

	/**
	 * @OA\Get(
	 *   path="/users/teste/{name}",
	 *   description="Teste DB",
	 *   operationId="teste",
	 *   tags={"Users"},
	 *   @OA\Parameter(name="name",
	 *     in="path",
	 *     required=true,
	 *     description="Teste",
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

	public function teste($name) {
		
		for($i=1;$i<5;$i++) {
			$a = new \StdClass();
			$a->id = $i;
			$a->name = "Teste ".$i;
			$a->username = "teste.teste".$i;

			$b[] = $a;
		}


		return array("name" => $name, "users" => $b);
	}
}