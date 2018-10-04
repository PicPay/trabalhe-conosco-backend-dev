<?php

namespace Usuarios\Models;

/**
 * Class UsersError
 *
 *
 * @author  Giancarlo Bacci <giancarlo.baci@gmail.com>
 *
 * @OA\Schema(
 *     description="Retorna o Erro dos usuários",
 *     title="User Error"
 * )
 */
class UsersError
{
	/**
	 * @OA\Property(
	 *     format="int32",
	 *     description="Código do Erro",
	 *     title="Code",
	 *     example=999
	 * )
	 *
	 * @var integer
	 */
	private $code;
	
	/**
	 * @OA\Property(
	 *     description="Descrição do Erro",
	 *     title="Message",
	 *     example="Descrição do Erro"
	 * )
	 *
	 * @var string
	 */
	private $message;
}