<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @api {get} /oauth/token Pegar token
 * @apiName PegarTokenAuh
 * @apiGroup Auth
 *
 * @apiParam {String} grant_type  utilize password
 * @apiParam {integer} client_id Id do consumidor da api. (Utilize 1 para o desafio)
 * @apiParam {String} client_secret Senha do consumidor da api. (Utiliza bnXSI5SigoHCx9dVHUT3nrTUfdVk9Sbvecda82bz para o desafio)
 * @apiParam {String} username username ou e-mail registrado no banco. (Utilize evecimar.silva para exemplo ou cadastre outro usuário com senha para o desafio)
 * @apiParam {String} password Senha do usuário do sistema. (Utilize qwe123 para o desafio).
 * @apiParam {String} scope É utilziado para gerenciar permissões. (Utilize * para o desafio).
 *
 * @apiParamExample {json} Request-Example:
 * {
 *      "grant_type":"password",
 *      "client_id": "1",
 *      "client_secret" : "bnXSI5SigoHCx9dVHUT3nrTUfdVk9Sbvecda82bz",
 *      "username" : "evecimar.silva",
 *       "password" : "qwe123",
 *      "scope" : "*"
 * }
 *
 * @apiSuccessExample Success-Response:
 *  HTTP/1.1 200 OK
 *  {
 *      "token_type": "Bearer",
 *      "expires_in": 86400000,
 *      "access_token": "token a ser utilizado no header das requisições da api",
 *      "refresh_token": ""
 *  }
 *
 * @apiErrorExample Error-Response:
 *  HTTP/1.1 401 Unauthorized
 *  {
 *      "error": "invalid_credentials",
 *      "message": "The user credentials were incorrect."
 *  }
 */

/**
 * @api {get} /api/user Pegar dados do usuário logado
 * @apiName PegarDadosUsuario
 * @apiGroup Usuarios
 *
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Accept" : "application/json"
 *       "Authorization": "Bearer {token disponibilizado na api /oauth/token}"
 *     }
 *
 * @apiSuccessExample Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *       "id": 1,
 *       "nome": "asdas",
 *       "cpf": "123123",
 *       "matricula": "123123",
 *       "data_desativacao": null,
 *       "email": "1231s@123123.com.br",
 *       "id_perfil": 1,
 *       "created_at": "2018-09-06 22:13:44",
 *       "updated_at": "2018-09-06 22:13:44",
 *       "perfil": {
 *           "id_perfil": 1,
 *           "perfil": "neque",
 *           "created_at": "2018-09-06 22:13:44",
 *           "updated_at": "2018-09-06 22:13:44"
 *       },
 *       "grupo": [
 *           {
 *               "id_grupo": 1,
 *               "grupo": "Facere",
 *               "created_at": "2018-09-06 22:13:50",
 *               "updated_at": "2018-09-10 14:49:06",
 *               "pivot": {
 *                   "id_usuario": 1,
 *                   "id_grupo": 1
 *               },
 *               "usuarios": [
 *                  {
 *                   "id_usuario": 1,
 *                   "id_grupo": 1,
 *                   "created_at": "2018-09-17 15:14:27",
 *                   "updated_at": "2018-09-17 15:14:27"
 *                   }
 *               ]
 *           }
 *       ]
 *   }
 *
 * @apiErrorExample Error-Response:
 *  HTTP/1.1 401 Unauthorized
 *  {
 *       "message": "Unauthenticated."
 *  }
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * @api {get} /api/users Pegar todos os usuários
 * @apiName PegarUsuarios
 * @apiGroup Usuarios
 *
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Accept" : "application/json"
 *       "Authorization": "Bearer {token disponibilizado na api /oauth/token}"
 *     }
 *
 * @apiSuccessExample Success-Response:
 *  HTTP/1.1 200 OK
 *   {
 *       "data": [
 *           {
 *               "id": "049dc170-b13f-41bd-b822-6889a3619c91",
 *               "nome": "Brunella Dias Damascena",
 *               "username": "brunella.dias.damascena",
 *               "id_auto": 8142499,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "05815a4b-1571-48c0-80d7-ab290e69b767",
 *               "nome": "Milca Vacarem",
 *               "username": "milca.vacarem",
 *               "id_auto": 8153838,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "0a28b0ca-73c0-40b7-9502-e685ba47a6f4",
 *               "nome": "Cleverton Martins",
 *               "username": "cleverton.martins",
 *               "id_auto": 8172378,
 *               "email": null,
 *              "created_at": null
 *           },
 *           {
 *               "id": "0a92a468-79ff-4334-94db-d5212ec515da",
 *               "nome": "Vania Clsudia",
 *               "username": "vania.clsudia",
 *               "id_auto": 8220849,
 *              "email": null,
 *               "created_at": null
 *          },
 *           {
 *               "id": "0bea8a99-f178-4cfe-9170-6ee1620a2720",
 *               "nome": "Marcela Bariani",
 *               "username": "marcela.bariani",
 *               "id_auto": 8166603,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "0c00d00f-4183-4c17-b6cf-fa41420c86af",
 *               "nome": "Chazaly Erivaldo",
 *               "username": "chazalyerivaldo",
 *               "id_auto": 8215733,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "10f54225-07af-4c04-bb0f-c4d25bc4ce4b",
 *               "nome": "Rafaela Larri",
 *               "username": "rafaela.larri",
 *               "id_auto": 8223794,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "128af6cc-a7db-4a62-90c4-889848cd3c06",
 *               "nome": "Elia Rossanezi",
 *               "username": "elia.rossanezi",
 *               "id_auto": 8182412,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "152bfd83-88a3-4786-95d5-a7b263fa4449",
 *               "nome": "Josenilson Pinho",
 *               "username": "josenilson.pinho",
 *              "id_auto": 8217829,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "156ed6eb-7777-4b85-8516-fabce190921d",
 *               "nome": "Alex ALMEIDA Mena",
 *               "username": "alex.almeida.mena",
 *               "id_auto": 8221847,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "189453fc-011b-4ea4-a964-f2b0479e1ce6",
 *               "nome": "Adimilson Tenorio",
 *               "username": "adimilson.tenorio",
 *               "id_auto": 8210676,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "1a2093a9-0bdb-43c7-acf3-f2d2decb9f25",
 *               "nome": "Jamerson Heidemann Aparecidi",
 *               "username": "jamersonheidemannaparecidi",
 *               "id_auto": 8138633,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "1b658968-2326-4532-a3c6-df59815a3a4b",
 *               "nome": "Josimar breda",
 *               "username": "josimarbreda",
 *               "id_auto": 8161133,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "1bec9b05-3641-4fe5-8d6f-43835dbafc47",
 *               "nome": "Sandrelly Guesser",
 *               "username": "sandrellyguesser",
 *               "id_auto": 8130680,
 *               "email": null,
 *               "created_at": null
 *           },
 *           {
 *               "id": "7e3d4092-6664-4162-9866-c4256507a35e",
 *               "nome": "Tatiana Arrieiro Filgueira",
 *               "username": "tatianaarrieirofilgueira",
 *               "id_auto": 7012517,
 *               "email": null,
 *               "created_at": null
 *           }
 *       ],
 *       "total": 15,
 *       "current_page": "http://localhost:8000/api/users",
 *       "current_page_number": 0,
 *       "first_page_url": "http://localhost:8000/api/users?page=0",
 *       "next_page_url": "http://localhost:8000/api/users?page=1&lastGeneralLimit=1&lastGeneralOffset=0",
 *      "path": "http://localhost:8000/api/users"
 *   }
 *
 * @apiErrorExample Error-Response:
 *  HTTP/1.1 401 Unauthorized
 *  {
 *       "message": "Unauthenticated."
 *  }
 */
/**
 * @api {get} /api/users?search={username, id ou email} Pegar todos os usuários de acodo com o filtro
 * @apiName PegarUsuariosFiltrados
 * @apiGroup Usuarios
 *
 * @apiHeaderExample {json} Header-Example:
 *     {
 *       "Accept" : "application/json"
 *       "Authorization": "Bearer {token disponibilizado na api /oauth/token}"
 *     }
 *
 * @apiSuccessExample Success-Response:
 *  HTTP/1.1 200 OK
 *   {
 *      "data": [
 *          {
 *              "id": "0252ce83-b1e7-4d1e-ac4b-b0322dfdaead",
 *              "nome": "Evecimar",
 *              "username": "evecimar.silva",
 *              "id_auto": 8207142,
 *              "email": "silva.evecimar@gmail.com",
 *              "created_at": null
 *          }
 *      ],
 *      "total": 1,
 *      "current_page": "http://localhost:8000/api/users?search=evecimar",
 *      "current_page_number": 0,
 *      "first_page_url": "http://localhost:8000/api/users?page=0&search=evecimar",
 *      "next_page_url": null,
 *      "path": "http://localhost:8000/api/users"
 *   }
 *
 * @apiErrorExample Error-Response:
 *  HTTP/1.1 401 Unauthorized
 *  {
 *       "message": "Unauthenticated."
 *  }
 */
Route::get('/users', 'UserController@index')->middleware('auth:api');
