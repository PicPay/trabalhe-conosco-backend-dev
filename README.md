# Teste Backend

## Descrição
Projeto foi implementado em java usando spring boot e elasticsearch.

## Dependencias
- Docker
- Maven
- JDK 1.8

## Como Implantar

### 1- Preparações iniciais.
Clone o projeto.
```
git clone https://github.com/rmradaelli/trabalhe-conosco-backend-dev.git
```
Baixe e descompacte o arquivo [users.csv.gz](https://s3.amazonaws.com/careers-picpay/users.csv.gz) para a pasta raiz do projeto.
Cerifique-se que exista um arquivo users.csv na raiz do projeto, pois ele será usado pelo docker.

### 2- Compile o projeto.
Abra um terminal na pasta do projeto e digite.
```
mvn compile
mvn package
```

### 3- Suba o Docker do Projeto

```
docker-compose up
```

Na primeira vez que o docker do projeto for executado o csv de usuários será exportado para o elasticsearch.
Esse processo demora aproximadamente 20 minutos.

## Como Usar

### Frontend
Acesse http://localhost:8082

Faça login usando o usuário picpay e senha picpay.

### Rest API

#### Login
Para fazer login envie uma requisição post para:
http://localhost:8082/login

Request Json Body:
```
{
  username: 'picpay'
  password: 'picpay'
}
```

Em caso de sucesso, a consulta irá retornar um token de autenticação no response header authorization.

### Consulta de usuários
Exemplo de consulta pelo login do usuário
```
http://localhost:8082/api/users?size=15&page=1&username=teste
```

Exemplo de consulta pelo nome do usuário
```
http://localhost:8082/api/users?size=15&page=1&name=teste
```
Onde:
- size = tamanho da paginação.
- page = número da página.
- name = nome do usuário que será usado na pesquisa.
- username = login do usuário que será usado na pesquisa.

O token de autentição deve ser adicionado no request header authorization.
