# Tecnologias

* Java 11
* Spring boot 2.1.3
* Kafka
* ElasticSearch
* Docker
* React

# Endpoint

 | Metodo | URI | Status |
 |--------| ----|--------|
 | GET | /v1/users | 200 |
 
# QueryParms

 | Nome    | Tipo    | Obrigatório |
 | ------- | ------- | ----------- |
 | keyword | string  | Sim         |
 | page    | integer | Não         |
 | size    | integer | Não         |
 
# Exemplo de execução

 | User  | Pass  | 
 | ----- | ----- |
 | admin | admin |
```bash
$ curl -H 'Authorization: Basic YWRtaW46YWRtaW4=' http://localhost:8080/v1/users?keyword=adr&page=0&size=200
``` 

# Front-end
Para executar a pagina de teste é necessario acessar pelo endereço ```http://localhost:8080/index.html``` e digitar o login e senha no popup que vai abrir



# Como executar

Basta executar o arquivo ```.start.sh``` que tudo rodara automaticamente.

## Sistemas testado
 * Linux ubuntu 14,16,18
 * Linux ec2 da aws
 * Linux ubuntu server
 * Mac OSx
 
 *Linux RedHat7, openSuse apresentou instabilidade.
 
# Importante 
O projeto usa vários programas pesados para atender os requisitos de performance do teste, portanto é aconselhável rodar em um ambiente Linux


### Mac OSx

O docker no Mac faz a emulação do ambiente portanto é importante alocar uma parte da memória e processador para o docker, o projeto exige uma quantidade rasurável de recursos do sistema.

Para o teste foi usado um Mac 2013, i5 - 8gb ram e ssd. A configuração ficou em 7164Mb ram e 4 cores reservado para o docker 

### Linux

Foram executados dois testes, um em um i7 e 16Gb ram e outro em um i5 com 8Gb ram.

O primeiro rodou tudo em aproximadamente 40 minutos com toda a carga do Elastic, o segundo demorou mais de 2 horas



```É possivel executar os testes enquando o banco é populado```
# Fonte 
* [Escrevendo 1MM/sec](https://medium.appbase.io/benchmarking-elasticsearch-1-million-writes-per-sec-bf37e7ca8a4c)
* [Kafka connect](https://medium.appbase.io/benchmarking-elasticsearch-1-million-writes-per-sec-bf37e7ca8a4c)


---

![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Teste Backend

O desafio é criar uma API REST que busca usuarios pelo nome e username a partir de uma palavra chave. Faça o download do arquivo [users.csv.gz](https://s3.amazonaws.com/careers-picpay/users.csv.gz) que contém o banco de dados que deve ser usado na busca. Ele contém os IDs, nomes e usernames dos usuários.

###### Exemplo
| ID                                   | Nome              | Username             |
|--------------------------------------|-------------------|----------------------|
| 065d8403-8a8f-484d-b602-9138ff7dedcf | Wadson marcia     | wadson.marcia        |
| 5761be9e-3e27-4be8-87bc-5455db08408  | Kylton Saura      | kylton.saura         |
| ef735189-105d-4784-8e2d-c8abb07e72d3 | Edmundo Cassemiro | edmundo.cassemiro    |
| aaa40f4e-da26-42ee-b707-cb81e00610d5 | Raimundira M      | raimundiram          |
| 51ba0961-8d5b-47be-bcb4-54633a567a99 | Pricila Kilder    | pricilakilderitaliani|



Também são fornecidas duas listas de usuários que devem ser utilizadas para priorizar os resultados da busca. A lista 1 tem mais prioridade que a lista 2. Ou seja, se dois usuarios casam com os criterios de busca, aquele que está na lista 1 deverá ser exibido primeiro em relação àquele que está na lista 2. Os que não estão em nenhuma das listas são exibidos em seguida.

As listas podem ser encontradas na raiz deste repositório ([lista_relevancia_1.txt](lista_relevancia_1.txt) e [lista_relevancia_2.txt](lista_relevancia_2.txt)).
Os resultados devem ser retornados paginados de 15 em 15 registros.

Escolha as tecnologias que você vai usar e tente montar uma solução completa para rodar a aplicação.

Faça um ***Fork*** deste repositório e abra um ***Pull Request***, **com seu nome na descrição**, para participar. Assim que terminar, envie um e-mail para ***desafio@picpay.com*** com o seu usuário do Github nos avisando.

-----

### Diferenciais

- Criar um frontend para realizar a busca com uma UX elaborada
- Criar uma solução de autenticação entre o frontend e o backend
- Ter um desempenho elevado num conjunto de dados muito grande
- Utilizar o Docker

