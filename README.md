# Procedimento pata execução do Desafio

## Pré-requisitos

- Git 
- Jdk 8
- Maven 3.5.4
- Docker
- Docker compose


## Passos

### 1. Clone Repository

git clone https://github.com/jherimum/trabalhe-conosco-backend-dev.git

### 2. Install artifacts

- cd trabalhe-conosco-backend-dev/
- mvn clean install

### 3. Subir Elastic Search

- docker-compose up -d

### 4. Executar populator

- cd populator/target/
- java -jar populador-0.0.1-SNAPSHOT.jar --datafile.path=**"{caminho_arquivo_users}"** --relevancies=**"{relevancias}"**

#### {caminho_arquivo_users}: Caminho completo do aquivo com usuarios - O valor padão é ${HOME}/users.csv
#### {relevancias}: lista de caminhos completos para os arquivos de relevanciamseparado por virgulas - A ordem dos arquivos que determina a sua relevancia. O valor Padrão é ${HOME}/lista_relevancia_1.txt,${HOME}lista_relevancia_2.txt


### 5. Subir Rest Api

- cd ../../rest/target
- java -jar rest-0.0.1-SNAPSHOT.jar


## Utilização da Api

A aplicação terá disponivel os seguintes endpoints.

### GET TOKEN

curl -X POST \
  'http://localhost:8080/oauth/token?grant_type=password' \
  -H 'Authorization: {basic authorization}' \
  -F username=eugenio \
  -F password=backend

#### {basic auhtorization} Basic authorization formado por username: picpay_client, password: secret


### REFRESH TOKEN

curl -X POST \
  'http://localhost:8080/oauth/token?grant_type=refresh_token&refresh_token={refreshtoken}' \
  -H 'Authorization: {basic authorization}' \

#### {basic auhtorization} Basic authorization formado por username: picpay_client, password: secret
#### {refreshtoken} refresh token gerado no endpoint get token


### Serach Users

curl -X GET \
  'http://localhost:8080/api/users?key_word={keyWord}&page={page}' \
  -H 'Authorization: Bearer {accesstoken}' \

#### {keyWord} palavra chave para procurar usuarios. Obrigatoria
#### {page} numero da pagina da busca. 0 based. Default :0
#### {accesstoken} access token gerado no endpoint get token 

<!---
![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)
--->
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

