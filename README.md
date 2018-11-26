# Roberto Morati

	API based on ElasticSearch (http://elastic.robertomorati.com)
	Administration: http://elastic.robertomorati.com/admin/login/?next=/admin/
	User: picpay   password: gvpthdpdr9kpkgkb
	Administration Dashboard allows create a new user and set priority in the new user. 
	The API can be used by the website: http://elastic.robertomorati.com

	Future enhancements:
	###Improve the script that was created in search.py to support searches based on all users. Nowadays it works fine, but the server has a "poor hardware" and was needed setup Swap Space to solve memory problem.
	###Setup OAuth2 to persist authentication on the mobile apps (clients). (I decided not setup authentication). 


## 1. API
	
	Test API: https://picpay.docs.apiary.io

## 2. Clone the project

	git clone https://bitbucket.org/robertomorati/picpay.git
	
## 3. Installation

	Before running the application it is necessary to set up the following the steps:
	### 3.1. Setup the database on settings.py (DATABASES). Thus, it's necessary to create the database. 
	### 3.2 It's necessary create an Index (ElasticSearch). In docker was used the follow image: docker.elastic.co/elasticsearch/elasticsearch:5.3.3 
	### 3.3 - The index should be created with the name "pcusers-index",by means of the command: curl -XPUT '<url__here>:<port_elastic_search>/pcusers-index?pretty'
	### 3.3.1 - In settings.py setup the ELASTICSEARCH_DSL.
	### 3.3.2 - Finally, setup the WSINFO and WSSEARCH with the address that will host the app.

	### 3.4 - Setup IP with the address that will host the app on picpay/static/util.js

	### In my server was used load-balancer and another container to set up the nginx (i.e.: folder nginx inside project)


## 4. In the project


	docker-compose build --force-rm
	docker-compose up -d

	### Inside the container setup superuser to access admin (http://elastic.robertomorati.com/admin/login/?next=/admin/) and run collectstatic
	./manage.py createsuperuser
	./manage.py collectstatic

	### migrations
	./manage.py migrate

	### setup index users, database users and priority users
	./manage.py index
	./manage.py load_priority
	./manage.py load_users
   
   
   
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

Faça um ***Fork*** deste repositório e abra um ***Pull Request***, **com seu nome na descrição**, para participar.

-----

### Diferenciais

- Criar um frontend para realizar a busca com uma UX elaborada
- Criar uma solução de autenticação entre o frontend e o backend
- Ter um desempenho elevado num conjunto de dados muito grande
- Utilizar o Docker

