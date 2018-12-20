![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Requisitos iniciais da aplicação.
Ter instalado o docker, docker-compose e composer

* https://docs.docker.com/install/
* https://docs.docker.com/compose/install/
* https://getcomposer.org/download/


### Iniciar aplicação e infraestrutura docker.

Após o clone do projeto entre no diretorio do mesmo (trabalhe-conosco-backend-dev) e execute os comandos abaixo.

- composer install (Responsavél por instalar as dependências do projeto)
- docker-compose up -d (Ele ira subir toda a infraestrutura necessária para o projeto)

- Descompactar o arquivo [users.csv.gz](https://s3.amazonaws.com/careers-picpay/users.csv.gz) dentro do diretorio 
<b>database/DataSeed/</b> com o nome <b>users.csv</b>

### Iniciando estrutura de banco de dados necessária para o projeto.

Para isto foi criado Migrations e Seeds, basta executar os seguintes comandos.

- php artisan migrate --database=mysql2 (Cria a estrutura do banco de dados)

- php artisan db:seed --class=InsertRelevanceList (Insere os registros dos arquivos de relevância no banco de dados).

- php artisan db:seed --class=InsertDataSample (Insere os dados contidos no <b>users.csv.gz</b> no banco de dados e no ElasticSearch)


###Observação.: 

######- Devido ao grande volume de dados contido no arquivo users.csv.gz a seed InsertDataSample (php artisan db:seed --class=InsertDataSample) pode demorar para ser inserido e indxado.


## Consultando a API

Na API é possivel fazer consultas de forma performatica tanto no Mysql como no ElasticSearch através das url abaixo.

- http://localhost:8000/api/v1/user/mysql?q=<param-search>
- http://localhost:8000/api/v1/user/elasticSearch?q=<param-search>

### Diferenciais

- Ter um desempenho elevado num conjunto de dados muito grande 
- Utilizar o Docker 


<b>Deixei o arquivo .env preenchido para comodidade na hora de testar o ambiente, em um cenario real o .env não deve ficar no github.</b>