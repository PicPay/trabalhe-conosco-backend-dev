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

# Solução

Foi desenvolvido um sistema que disponibiliza via URL http://<host da aplicação> um sistema com duas telas. A primeira disponibiliza consulta à base de dados MySQL e a segunda consulta a base de dados do Elasticsearch. É possível visualizar no topo da tela o tempo necessário para a consulta, permitindo ao usuário comparar as duas abordagens.

Para facilitar a comparação das consultas das duas telas, os resultados podem ser exibidos ordenados por nome. Caso seja escolhido ordenar, será possível testar o impacto da ordenação no tempo de consulta do MySQL e do Elasticsearch. Obs: Não é feita ordenação por username.

Para a construção da solução foram levadas em consideração algumas das práticas propostas pela metodologia do [The Twelve-Factor App](https://12factor.net/config)

# Limitação

O Elasticsearch possui uma limitação no que diz respeito à paginação de conjuntos de dados muito grandes. Se tentarmos, por exemplo, acessar a última página (538545) do conjunto de dados fornecido sem qualquer filtro, o Elasticsearch vai acabar dando timeout, enquanto o MySQL consegue retornar. Não consegui encontrar uma solução para isso até o momento.

Lembrando apenas que o caso acima é extremo. Para várias consultas, mesmo com a ordenação por nome, o número de páginas se restringe ao número na casa dos milhares, o que mantém o tempo de busca em poucos segundos.  

### Autor
- Nome: Rodrigo Alves Sarmento
- E-mail: rasarmento@gmail.com

### Tecnologias
- Docker
- Docker Compose
- MySQL 5.7
- Elasticearch 6.6
- Symfony 4.2
- Angular 4.x
- Tema Bootstrap Smartadmin 1.8 ([Visitar](https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0))

### Configuração
- Criar o arquivo ***app/.env*** a partir do ***app/.env.dist***
- No arquivo ***app/.env*** preencher a URL do servidor que contém a api (servidor do docker)
- Criar o arquivo ***.env*** a partir do ***.env.dist***
- No arquivo ***.env*** preencher os dados de configuração do container docker ***mysql***: ***MYSQL_ROOT_PASSWORD***, ***MYSQL_DATABASE***, ***MYSQL_USER*** e ***MYSQL_PASSWORD***.
- No arquivo ***.env*** preencher os dados da URL de conexão do doctrine: ***DATABASE_URL***
- No arquivo ***.env*** preencher os locais dos arquivos com os dados de usuários: ***USERS_FILE_PATH***, ***PRIORITY1_FILE_PATH*** e ***PRIORITY2_FILE_PATH***.
- No arquivo ***.env*** preencher o domínio de onde serão enviadas as requisições à API: ***CORS_ALLOW_ORIGIN***.
- No arquivo ***.env*** preencher a URI do Elasticsearch: ***ELASTIC_HTTP_CLIENT_BASE_URI***.
- Obs: Para cada configuração será fornecido um exemplo

### Instalação
- Construir containers: ```docker-compose -f docker-compose.yml -f app/docker-compose.prod.yml up -d --build```
- Realizar deploy: ```./cli/deploy```
- Carregar base de dados MySQL: http://<host da aplicação>:8080/api/user/import
- Carregar base de dados Elasticsearch: http://<host da aplicação>:8080/api/user/es/import
