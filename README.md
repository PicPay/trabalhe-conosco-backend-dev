![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Teste Backend - Solução

Tecnologias Utilizadas:
- Mavem, para compilar e gerenciar as dependências.
- Spring Boot (+ IDE Eclispe), para implementar toda a camada de backend da solução.
	- Módulos: spring-boot-starter-web, spring-boot-starter-thymeleaf, spring-boot-starter-data-jpa, spring-boot-devtools, spring-boot-starter-security, spring-boot-starter-test.
- Docker, para montar o servidor de banco de dados MySQL.
- Bootstrap, para o layout da página index.html.
- Jquery, para auxiliar na montagem da UX e realizar a consulta via requisição ajax.



### Docker

Para levantar o banco de dados com o Docker, abra o Windows PowerShell ou o Terminal, navegue até a pasta do arquivo `docker-compose.yml` e execute o comando "docker-compose up". Aguarde um pouco e o banco estará UP já com o schema `picpay` criado.

Para facilitar, abaixo segue o conteúdo do `docker-compose.yml`: 

```
version: '3'
services:
  db:
    image: mysql:5.7.22
    restart: always
    container_name: renan_mysql
    working_dir: /application
    environment:
      - MYSQL_ROOT_PASSWORD=root
      - MYSQL_DATABASE=picpay
    ports:
      - "3366:3306"
```



### Rodando o Projeto

- Como foi utilizado o Spring Boot para o projeto, basta fazer o clone do código, executar o "mvn clean install" e importá-lo no Eclise (File -> Import -> Existing Maven Projects).
- Já com o projeto importado, clique com o botão direito na classe ApplicationStart e escolha a opção Run As -> Java Application. O próprio Spring Boot irá se encarregar de publicar a aplicação no tomcat.



### Acessando

Através da URL: http://localhost:8080 é possível acessar uma página com 2 campos para login e senha. Utilize os seguintes dados:

- Usuário: picpay
- Senha: test123

Foi utilizado Basic Autentication com os usuários inseridos na memória do servidor. Mas a alteração para validação consultando o banco de dados pode ser implementada sem grandes dificuldades na classe SecurityConfig, localizada no pacote security.



### Importando os Dados

Para importar os dados faça um post para a URL: http://localhost:8080/import utilizando uma autenticação básica (Basic Autentication) com os mesmos dados do acesso acima.

A importação fará download diretamente dos seguintes links disponibilizados pela picpay:
- https://s3.amazonaws.com/careers-picpay/users.csv.gz
- https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt
- https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt

A importação não é @Transational, por isso, mesmo que ela demore, já pode-se testar o funcionamento da consulta na tela inicial.
 


-----

Abaixo segue a versão do README no qual a solução foi baseada. 

-----



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