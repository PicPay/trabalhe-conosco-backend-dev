![alt text](./pp-ui/src/assets/logo.png)

# PicPay - Desafio Backend

Desafio backend para o PicPay, criar uma ferramenta de busca em uma base de mais de 8 mi de registros
Para tanto deve ser considerada uma lista de relevância que determinará a ordem da consulta caso o usuário esteja
em uma destas listas.

## Índice 
- [Instalação](#Instalacao)  
- [Como Utilizar](#Como-Utilizar)  
- [Exemplos](#Exemplos)   
- [Melhorias e Considerações](#Melhorias-e-Considerações)

## Instalação

Para o desafio foram utilizadas as seguintes tecnologias:

* Java 11
* Spring Boot 
* Docker 
* Maven
* React
* ElasticSearch
* JWT
* Cucumber

Foram definidas as seguintes portas:

* pp-backend (aplicação backend) : 7700
* pp-ui (frontend) : 7710
* ElasticSearch : 7720 e 7730

Os arquivos users.csv e lista de relevancia 1 e 2 devem estar na pasta resources
junto da application.properties

## Como utilizar

As aplicações foram containerizadas como proposto no desafio
para roda-las e preciso somente rodar o comando :

```docker
docker-compose up --build
```

para rodar os Apps e do ElasticSearch e iniciar os containeres.

primeiro realizar a sincronização da lista de usuários

GET /synchUsersList

depois carregar as listas de relevancia 

GET /synchRelevancyList 

## Exemplos


#### Autenticação no Backend

foram utilizados usuário e senha fixos para esse desafio

```
curl -v POST  -H "Content-Type: text/plain" --data '{"username" : "admin", "password" : "admin"}' http://localhost:8080/login
```

#### Consulta ElasticSearch

```
 curl -X GET http://localhost:7720/pp_user/_search -H 'Content-Type: application/json' -d '{
   "query":{
      "match_all":{}
   }
}'
```

#### Api para sincronização de arquivos

Sincronização das listas de relevância
```
curl -X GET http://localhost:8080/api/user/synchRelevancyList 
-H "Authorization: Bearer token"
```

Sicronização da lista de usuários
```
curl -X GET http://localhost:8080/api/user/synchUsersList 
-H "Authorization: Bearer 'token'"
```
substituir 'token' pelo token gerado na requisição POST acima

exemplo de token:

Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJhZG1pbiIsImV4cCI6MTU1NTQ3NjE5Mn0.em6Cv0NxcOfthxvoCLOqmRI4iXqUvelzm5xE5iZKkvCm1OhQmdt7hnJU92WqovqBC6m7ATKryxXzIpg010A5gg

Obs: por motivos de simplificação não realizei a parametrização das listas, para exemplificar o 
processamento assíncrono dos arquivos na inicialização do sistema.

## Melhorias e considerações

Para realizar o rocessamento de todos os arquivos levará em média 25 minutos, foram realizadas medições
com diferentes quantidades de threads e chunk sizes, foram selecionadas as quantidades que melhor adequaram.

Para resolver o desafio, decidi utilizar de tecnologias as quais não tinha muito conhecimento
porém são ótimas para esse tipo de situação, como React e ElastiSearch.

A idéia seria utilizar o Kafka e também a solução Logstash com o Kibana,
para indexar os dados no ElasticSearch oque seria interessante caso o sistema estivesse em produção
assim poderia gerar metricas de uso no Kibana.
Porém demandaria mais esforço e o desafio ficaria grande demais.
 
Portanto foi entregue a solução para o desafio

[#Instalação]: #Instalação