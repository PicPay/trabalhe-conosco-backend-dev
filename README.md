# Teste Backend
Paulo Henrique de Siqueira
paulohenriqu@hotmail.com
https://www.linkedin.com/in/paulohenriquesiqueira/

### Stack utilizado

Esta solução foi desenvolvida utilizando as seguintes tecnologias:

* Spring Boot
* MongoDB
* Elasticsearch
* Angular
* Docker

And of course Dillinger itself is open source with a [public repository][dill]
 on GitHub.

### Execução

Os seguintes passos são necessários para rodar a solução:

1) Construir a aplicação Java com o Maven
```sh
$ cd server
$ mvn clean install -DskipTests
```
2) Na pasta raiz do projeto rodar o docker-compose
```sh
$ docker-compose up
```

3) O container do Spring Boot (pic-rest) aguarda 30s para que o mongo e o elasticsearch terminem de inicializar. Após isso o projeto Java começa a rodar e inicia o job para importar os registros, neste momento, enquanto os registros são importados, a api já está disponível, no entanto ainda sem a priorização pelas listas de relevância.

A API é protegida usando JWT, para gerar o token é necessáio fazer uma requisição POST para o endpoint de autenticação com os dados do usuário padrão:
```
curl -X POST \
  http://localhost:8080/api/authenticate \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -H 'postman-token: a33b0b31-3bd6-c0aa-cab6-f250a46c5d47' \
  -d '{"username":"user",	"password":"password"}'
```

O token será retornado no header da resposta.

O endpoint que gerencia as buscas é o /api/usr-data
Os query parameters aceitos são:
* query - O termo a ser pesquisado no name ou username
* page - a página do resultado, começando em 0
* size - a quantidade de resultados retornados, o padrão é 15

Exemplo de requisição:
```
curl -X GET \
  'http://localhost:8080/api/usr-data?query=rafa' \
  -H 'authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJzZWN1cmUtYXBpIiwiYXVkIjoic2VjdXJlLWFwcCIsInN1YiI6InVzZXIiLCJleHAiOjE1NTM5NjY5ODIsInJvbCI6WyJST0xFX1VTRVIiXX0._wpp_VXYk1QXLu5mAxYHxwezJAh0nBc8-_1eTma9FmvLs5fJlVgbXOJVFf8U3ZuYYerrh5kiFMmSqtmk0XIrvg' \
```

A interface gráfica pode ser acessada na porta 80:
http://localhost:80

Usuário: user
Senha: password

### Observações

O MongoDB foi utilizado apenas para simular uma situação onde existe uma base de dados primária e o elasticsearch utilizado para indexação para fins de buscas (e pelo desafio de utilizar um banco não relacional).