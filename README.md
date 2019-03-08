# Example Java Spring Boot API

## Prerequisites

Docker

## Installing

Baixe este projeto. No prompt de comando, acesse o diretório do projeto e execute o comando para subir os containers:

```
$ docker-compose up --build
```

O Docker realizará o download do Banco de Dados remoto disponibilizado (cerca de 500mb). Dependendo da velocidade da internet, realizar o download e subir os containers poderá demorar de 30 a 40 minutos.
Aguarde a execução da aplicação. Ao final, o sistema irá retornar uma mensagem nos logs:
```
Started ExampleApiApplication in x seconds
```

Este procedimento deverá levar alguns minutos devido às migrações executadas para o banco de dados da aplicação.

## Getting Started

Para ter acesso aos serviços criados para este teste, utilize a URL abaixo para importar o projeto no Postman e realizar através dele as requisições necessárias para teste.
Todas as requisições já estarão pré criadas, necessitando apenas a solicitação de um novo token para autenticação.
```
https://www.getpostman.com/collections/850a6e83659cebf54efa
```

## Running the tests

Realizar um POST na seguinte URL:

```
http://localhost:8083/oauth/token
```

### Authorization

Utilizar a Basic Auth com as seguintes informações:
* Username		= my-frontend
* Password		= myFr0nt3nd


O corpo da requisição (Content-Type: application/x-www-form-urlencoded) deverá conter as seguintes informações (key=value):
* client		= my-frontend
* username		= admin
* password		= admin
* grant_type	= password

O sistema retornará um "access_token", que deverá ser utilizado como autenticação (Bearer Token) nas requisições de busca de pessoas:
```
{
    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX25hbWUiOiJhZG1pbiIsInNjb3BlIjpbInJlYWQiLCJ3cml0ZSJdLCJleHAiOjE1NDQ0MTIwOTYsImF1dGhvcml0aWVzIjpbIlJPTEVfU0VBUkNIX1BFUlNPTiJdLCJqdGkiOiI5NGE3ZDQ4OC0yZjAwLTRiNDktYmVkNC02YjI4ZjcyMTM4YmQiLCJjbGllbnRfaWQiOiJteS1mcm9udGVuZCIsInVzZXJuYW1lIjoiYWRtaW4ifQ.gQDucn1CuAiyKrnvSfLJlvYVocTw21TkPZb3Nl2eEsk",
    "token_type": "bearer",
    "expires_in": 3599,
    "scope": "read write",
    "username": "admin",
    "jti": "94a7d488-2f00-4b49-bed4-6b28f72138bd"
}
```

### Renew Token

Ao obter a mensagem de token expirado, basta enviar um POST para a mesma URL, porém o corpo da requisição (Content-Type: application/x-www-form-urlencoded) deverá conter apenas:
* grant_type	= refesh_token

### Search Users

Realizar um GET com a seguinte URL:

```
http://localhost:8083/people?searchString=
```

Para passar uma String de busca, basta preencher o parâmetro searchString com o valor desejado.
O sistema retornará a primeira página de resultados.

A lista de prioridades foi incorporada à tabela de pessoas e o valor da prioridade também será retornada no resultado busca.

```
{
    "content": [
        {
            "id": "6e172695-c76c-4364-8dd9-44e6d2d3aed9",
            "name": "Heitor Rovaron",
            "username": "heitor.rovaron",
            "priority": null
        }
    ],
    "pageable": {
        "sort": {
            "unsorted": true,
            "sorted": false,
            "empty": true
        },
        "pageSize": 15,
        "pageNumber": 0,
        "offset": 0,
        "paged": true,
        "unpaged": false
    },
    "totalPages": 1,
    "totalElements": 1,
    "last": true,
    "first": true,
    "sort": {
        "unsorted": true,
        "sorted": false,
        "empty": true
    },
    "numberOfElements": 1,
    "size": 15,
    "number": 0,
    "empty": false
}
```

## Stopping Containers

Para parar os containers em execução:

```
$ docker-compose stop
```

