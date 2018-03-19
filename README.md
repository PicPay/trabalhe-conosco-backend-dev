![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Solução por Keoma K.

A aplicação foi construida utilizando Java (EJB com Hibernate) e Mysql.

## Banco de Dados

Teremos que criar o schema **picpaydb** e 3 tabelas: **USUARIO** e **RELEVANCIA**. 
O script para criar as tabelas esta no projeto no arquivo [tabelas.txt](Arquivos/tabelas.txt)

Após criar as tabela faremos a carga inicial, no caso da tabela **RELEVANCIA** o script esta 
conforme os arquivos de lista de relevancia sugeridos do teste, podemos encontrar em [listas_de_prioridade.txt](Arquivos/listas_de_prioridade.txt). 

A carga da tabela **USUARIO** poderá ser feita de duas maneiras:

- Executando o script que esta no arquivo [carga_de_usuarios.txt](Arquivos/carga_de_usuarios.txt) (possui 4000 registros) 
- Com a aplicação rodando utilizar-mos a URL **localhost:8080/consulta/rest/carga?aquivo=CAMINHO_DO_ARQUIVO_USER.CSV_NA_SUA_MAQUINA**.



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

=======
API REST que busca usuários pelo nome e username a partir de uma palavra chave.

Estes são os requisitos para rodar a aplicação :

Java 8
MySql
Banco de dados

Teremos que criar o schema 'picpaydb' e 3 tabelas: USUARIO, LISTA_RELEVANCIA_1 e LISTA_RELEVANCIA_2. O script para criar as tabelas esta em arquivos/tabelas.txt. Após criar as tabela faremos a carga inicial, no caso das tabelas LISTA_RELEVANCIA_1 e LISTA_RELEVANCIA_2 o script esta conforme os arquivos sugeridos do teste, podemos encontrar em arquivos/listas_de_prioridade.txt. A carga da tabela USUARIO poderá ser feita de duas maneiras:

Executando o script que esta em arquivo/carga_de_usuarios.txt (possui 4000 registros)
Com a aplicação rodando utilizar-mos a URL localhost:8080/consulta/carga?C:\CAMINHO_DO_ARQUIVO_USER.CSV_NA_SUA_MAQUINA.
>>>>>>> cf5127d3f8acf17f81d3bc7ebba96efec8da4ba7
