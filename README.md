![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Requisitos iniciais da aplicação.
Ter instalado o docker, docker-compose e composer

* https://docs.docker.com/install/
* https://docs.docker.com/compose/install/
* https://getcomposer.org/download/


### Iniciar aplicação e infraestrutura docker.

Após o clone do projeto entre no diretorio do mesmo (trabalhe-conosco-backend-dev) e execute os comandos abaixo seguindo a sequencia.

- composer install (Responsavél por instalar as dependências do projeto)

- docker-compose up -d (Ele ira subir toda a infraestrutura necessária para o projeto)

### Observação.: 
##### - Após a execucão do comando (docker-compose up -d) os dados serão updados automaticamente pelo docker, este processo leva em torno de 3~5 minutios até que o mysql fique completamente pronto.

## Consultando a API - Mysql

Na API é possivel fazer consultas de forma performatica tanto no Mysql como no ElasticSearch através das url abaixo segui.

- http://localhost:8000/api/v1/user/mysql?q=<param-search>

![Consulta_api_mysql](imgs_readme/consulta_api_mysql.png?raw=true "Title")

## Consultando a API - ElasticSearch

###### Para usar a consulta via elasticsearch precisamos enviar os dados da tabela mysql para ser indexado no mesmo. 

- php artisan db:seed --class=InsertDataSampleToElasticsearch (Insere os dados que foram updados no MySQL para o ElasticSearch)


- http://localhost:8000/api/v1/user/elasticSearch?q=<param-search> (Url de consulta através do elasticsearch)

![Listar Gasto](imgs_readme/consulta_api_els.png?raw=true "Title")


### Diferenciais

- Ter um desempenho elevado num conjunto de dados muito grande 
- Utilizar o Docker 


### Observação.: 
<b>Deixei o arquivo .env preenchido para comodidade na hora de testar o ambiente, em um cenario real o .env não deve ficar no github.</b>



