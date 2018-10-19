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

-----

# Solução

O backend foi desenvolvido com a utilização do framework Spring Data REST, com banco H2 embedded.
Uma UI simples foi construída em ReactJS para listar o resultado da busca com paginação.

### UI

A aplicação ReactJS utiliza webpack para compilar todos os arquivos num bundle. Usa rest.js para comunicação com a API REST. E usa babel para compilar ES6 para ES5.

### Segurança

A API está protegida por BASIC AUTHENTICATION, via Spring Security (usuário e senha: bruno).

### Docker

Um arquivo Dockerfile foi adicionado ao projeto permitindo a criação de uma imagem baseada no JDK8.
Para gerar a imagem, basta executar do diretório do projeto:

`docker build . -t user-search`

Depois de baixar a imagem, basta executá-la:

`docker run image user-search`

### Executando na máquina local

Não é necessário ter npm e nodeJS na máquina local para executar a UI.
Basta executar:

`mvn spring-boot:run`

Esta operação demandará um bom tempo porque, além de instalar npm e nodeJS embedded, vai fazer o download do arquivo users.csv.gz, descompactá-lo e carregar o banco de dados H2.

## Melhorias

- Otimizar o banco de dados H2 para melhor performance de LOAD e SEARCH
- Utilizar um banco de dados noSQL
- Criar mais unit tests e integration tests
