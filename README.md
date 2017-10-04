# A solução

A solução está dividida em dois projetos, cliente e servidor. Ambos utilizam o Spring Boot, provendo a interface de serviços RESTFul.

Para armazenar os dados dos usuários, optei pelo banco de dados NoSQL MongoDB.


## Executando o projeto
1. git clone https://github.com/tmontovaneli/trabalhe-conosco-backend-dev.git
2. docker run --name db_mongo -v /tmp/data:/data/db -d -p 27017:27017 mongo
3. Entre na pasta do projeto server e execute 'docker build -t tmontovaneli/picpay_server .'
4. Entre na pasta do projeto client e execute 'docker build -t tmontovaneli/picpay_client .'
5. Inicie o container do servidor: 'docker run --name picpay_server -p 8080:8080 -e HOST="172.17.0.1" -e PORT="27017" tmontovaneli/picpay_server', onde as variáveis HOST e PORT são referentes ao container do MongoDB
6. Inicie o container do client: 'docker run --name picpay_client -p 8090:8090 -e HOST="172.17.0.3" -e PORT="8080" tmontovaneli/picpay_cliente', onde as variáveis HOST e PORT são referentes ao container do server.





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

Faça um fork deste repositório e abra um pull request para participar.

-----

### Diferenciais

- Criar um frontend para realizar a busca com uma UX elaborada
- Criar uma solução de autenticação entre o frontend e o backend
- Ter um desempenho elevado num conjunto de dados muito grande
- Utilizar o Docker

