# Roberto Morati

API based on ElasticSearch (http://elastic.robertomorati.com)

Administration (allows create a new user and set priority in the new user. ): http://elastic.robertomorati.com/admin/login/?next=/admin/

User: picpay   
password: gvpthdpdr9kpkgkb


Future enhancements: Setup OAuth2 to persist authentication.


## 1. Clone the project

	git clone https://github.com/robertomorati/trabalhe-conosco-backend-dev.git
	
After that, download and unzip the file: [users.csv.gz](https://s3.amazonaws.com/careers-picpay/users.csv.gz) into the root project (~/development/repository/trabalhe-conosco-backend-dev):

	wget https://s3.amazonaws.com/careers-picpay/users.csv.gz
	
The file users.csv will be used to load the users into the database. A load of users to ElasticSearch will be made from the database. This process will use  ~ 452 Mb of RAM. 


## 2. In the project


	docker-compose up -d --remove-orphans

The time:

- to load the users into the database (MySQL) is between 30 - 80 minutes.

- to load the users from the database to ElasticSearch is between 10 - 22 minutes.
	
   
## 3. Testing the API


To acess the frontend (Search API> Search User): 
	
	http://127.0.0.1:8080/
	
To access the admin area: 
	
	http://127.0.0.1:8080/admin/
	
- user: picpay
- password: picpay@2018
	
	
## 4. API
	
Test API: https://picpay.docs.apiary.io (old depends on elastic.robertomorati.com)
	
First, retrieves basic info to start the search based on <data_search>. The data_search is the string to search. 

- http://127.0.0.1:8080/api/v1/info/<data_search>/
- Example of response (http://elastic.robertomorati.com/api/v1/info/ana/) (total of users found is 33350, token to retrieves the users and total of pages):

		{
		    "total": 33350,
		    "success": "The search found 33350 user(s) in 85 milliseconds",
		    "token": "e44683376ee0",
		    "pages": 2223
		}
	
Second, retrievesthe users based on <data_search>, < token > and < page >. The data_search is the string used above (the same), the token was retrives above and the page. 

- http://127.0.0.1:8080/api/v1/users/<data_search>/< token >/< page >/
- http://elastic.robertomorati.com/api/v1/users/ana/e44683376ee0/1/
	
		[
		    {
			"id": "365df9cc-062e-485b-ba8a-cc708cbed4ff",
			"username": "analucia.norges",
			"full_name": "Analucia Norges"
		    },
		    {
			"id": "02014677-032f-48eb-89a9-6e0a4074fa50",
			"username": "analuagaitolini",
			"full_name": "Analua Gaitolini"
		    },
		    {
			"id": "0160e03d-3030-4e23-8785-298b01a6656a",
			"username": "loiza.ananias.goncalez",
			"full_name": "Loiza Ananias Goncalez"
		    },

		    .....

	    ]	
    
    
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