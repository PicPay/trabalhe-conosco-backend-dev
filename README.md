## **Introdução**
Neste repositório se encontra a solução para o desafio proposto pela PicPay, foram utilizadas as seguintes tecnologias: Docker, Postgres, Angular, NodeJS e Redis. A seguir detalharei como cada tecnologia foi empregada.
## **Como iniciar**
Necessita que se tenha instalado Docker ([Guia de instalação](https://docs.docker.com/engine/installation/)) e Docker-compose ([Guia de instalação](https://docs.docker.com/compose/install/)). Antes de iniciar, verifique se algumas das portas a seguir estão sendo utilizadas: 4200 (AngularJS), 3000 (Servidor NodeJS), 5432 (Postgres) e 6379 (Redis), caso estejam, há duas opções, para o serviço que está usando a porta ou mudar o mapeamento de portas no arquivo docker-compose.yml que está no diretório raiz desse repositório.  Após isso, entre no diretório raiz do repositório e rode: 
```docker-compose up``` 
## **Docker**
Foram utilizados Dockerfiles para isolar os ambientes, sendo criados 3 dockerfiles, dois com NodeJS (Um para o back-end e outro para o Front-end) e um com o Postgres. Dentro do arquivo docker-compose.yml também o uso da minha imagem do Redis, que não foi necessário criar um Dockerfile exclusivo para ele.
### **Inicialização do banco de dados**
A imagem utilizada possui um ENTRYPOINT localizado em `/docker-entrypoint-initdb.d/` todos os arquivos necessários para configuração do banco foram baixados e colocados no entrypoint criado, o script responsável se encontra no Dockerfile dentro da pasta db. O trecho responsável pela preparação dos arquivos é:

    RUN curl -o users.csv.gz https://s3.amazonaws.com/careers-picpay/users.csv.gz
    RUN gunzip users.csv.gz
    RUN curl -o lista1.csv https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt
    RUN curl -o lista2.csv https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt
    ADD init.sql /docker-entrypoint-initdb.d/ 

Na última linha do trecho acima é adicionado um arquivo chamado `init.sql` ao entrypoint, todo arquivo .SQL ou .SH que estão nesse diretório do docker serão executados após o contêiner ser montado, esse arquivo é responsável pela criação do schema, tabelas, importação dos dados a partir do CSV e crianção de índices que aumentam sensivelmente o tempo de resposta a consultas no banco de dados. Segue parte do script SQL:

    CREATE SCHEMA IF NOT EXISTS picpay;
    CREATE TABLE picpay.registers(  
       id UUID PRIMARY KEY,
       name varchar(50),
       username varchar(50)
    );
    
    CREATE TABLE picpay.rank1(  
       id UUID PRIMARY KEY
    );
    CREATE TABLE picpay.rank2(  
       id UUID PRIMARY KEY
    );
    COPY picpay.registers FROM '/docker-entrypoint-initdb.d/users.csv' CSV;
    COPY picpay.rank1 FROM '/docker-entrypoint-initdb.d/lista1.csv' CSV;
    COPY picpay.rank2 FROM '/docker-entrypoint-initdb.d/lista2.csv' CSV;
    CREATE INDEX ix_users_name_lower ON picpay.registers (lower(name) varchar_pattern_ops);
    CREATE INDEX ix_users_username_lower ON picpay.registers (username varchar_pattern_ops);
O banco foi indexado no campo nome em lower case para que nossas buscam sejam realizadas de forma mais eficiente independente se o usuário digitou letras maiúsculas, isso não se fez necessário no campo username já que todos estão letras minúsculas. 

## **Postgres**
Os 3 arquivos fornecidos foram importados em 3 tableas distintas, sendo 2 com apenas um campo do tipo UUID e outra com UUID, name e username. Para chegar a conclusão de usar o Postgres fiz comparações com MySQL e MongoDB. MySQL demonstrou um baixo desempenho tanto na importação quanto na consulta dos dados, sendo o primeiro a ser descartado. O MongoDB por não se tratar de um banco relacional, precisariam ser feitas alterações em suas collections para que podesse ser feito uma ordenação por prioridade. Desta forma haveria mutações estruturais nos dados fornecidos para que fosse possível o uso do MongoDB, que em caso de crescimento do banco de dados geraria um overhead onde seria necessário adequear os dados novos ao formato utilizado no banco de dados (caso a lista de prioridade crescesse junto com a tabela de informações). Por esses fatores o banco escolhido foi o Postgres 9.x.

A query utilizada para obtenção dos dados foi:


----------

```
SELECT users.* FROM picpay.registers users 
LEFT JOIN picpay.rank1 ON rank1.id = users.id 
LEFT JOIN picpay.rank2 ON rank2.id = users.id
WHERE users.name LIKE lower('name%')
OR users.username LIKE 'name%'
ORDER BY rank1.id is null, rank2.id is null, users.id
LIMIT 15 OFFSET offset
```


----------
Como comentado a parte de indexação do banco, a consulta no campo nome não precisa usar a função lower() já que ela foi utilizada no momento que indexamos esse campo, ela é utilizada apenas na variável que vem do usuário, já que pode ter digitado letras maiúsculas.
Onde name e offset são paramêtros de usuário, onde name se refere ao valor que ele quer consultar no banco e offset a paginação.

## **Redis**
O Redis é um armazenamento de estrutura de dados de chave-valor de código aberto e na memória. Desta forma, conseguimos um ganho notável nas requisições, já que foi adicionado adicionado um sistema de cache, quando forem feitas as mesmas consultas o sistema responderá **muito** mais rápido.

##**NodeJS**

Node foi escolhido devido a sua grande simplicidade e robustez . Com poucas linhas de código foi possível fazer toda a parte de back-end, separando em 3 principais arquivos: queries.js (Responsável por fazer a consulta ao banco de dados e responder a rota), index.js (Que tem o papel de receber a solicitação em uma determinada rota e repassar ao controller responsável o tratamento da requisição) e por fim server.js que é responsável pelas configurações iniciais para que nosso servidor funcione.





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