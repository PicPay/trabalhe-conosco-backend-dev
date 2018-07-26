# Procedimento pata execução do Desafio (Eugenio Perrotta Neto - eugenio.perrottaneto@gmail.com)

## Pré-requisitos

- Git 
- Jdk 8
- Maven 3.5.4
- Docker
- Docker compose


## Passos

### 1. Subir os containers

Para subir os containers da aplicação, basta usar o comando docker-compose up.

Ao ser executado, três containers subirão:

- elasticsearch: servidor do elaticsearch
- populador: aplicacao que lê os arquivos de usuários e relevâncias e indexa os documentos no elasticsearch
- rest: disponibiliza a api para pesquisa de usuários

A imagem do populador, que está no dockerhub já contêm os arquivos de relevância e usuários!
Quando o container sobe, o arquivo de usuários é descompactado e suas linhas processaadas! Esse processo é bem demorado! MUITO MESMO! A descompactção e o processamento. Afinal são 8 milhoes de registros! E como ativei o log, para poder cacompanhar o processo, o processo poderá ficar um pouco mais lento. Poderá não. Ficará!
Tentei elaborar uma solução mais robusta para indexar as linhas, splitando o arquivo em vários outros menores e para cada um deles abriria uma thread para processá-los. Entretanto, o elasticsearcj não aguentou o regasso! Como não tenho muita familiaridade com o elasticsearch não consigui configura-lo de uma maneira que pudesse suportar o elevado número de requisços de inserção! Pensei também em utilizar a inserção em lote do elasicsearch para dar mais robustez, mas achei que talvez não fosse adiantar! Estou pensando em fazer uns testes, até para aprendizado!
Ainda no populador, infelizmente fiz uma coisa aque me envergonha muito! Coloquei um Thread.sleep para iniciar o processo porque não consegui usar o https://github.com/vishnubob/wait-for-it para controlar a subida do container só depois que a porta do elasticsearch estivesse disponível. Infelizmente não consegui! 


### Gerar os artefatos
Se for de interesse gerar todos os artefatos novamente, basta executar o comando mvn clean deploy.
O maven fará todo build, geração de imagens e o push no dockerhub. Depois disso feito é só executar o comando do passo 1.



## Utilização da Api

A aplicação terá disponivel os seguintes endpoints. 
Coleção disponibilizada no Postman: https://www.getpostman.com/collections/2f5e658575e280cd7967

### GET TOKEN

curl -X POST \
  'http://localhost:8080/oauth/token?grant_type=password' \
  -H 'Authorization: Basic cGljcGF5X2NsaWVudDpzZWNyZXQ=' \
  -F username=eugenio \
  -F password=backend


### REFRESH TOKEN

curl -X POST \
  'http://localhost:8080/oauth/token?grant_type=refresh_token&refresh_token={refreshtoken}' \
  -H 'Authorization: Basic cGljcGF5X2NsaWVudDpzZWNyZXQ=' \

#### {refreshtoken} refresh token gerado no endpoint get token


### Serach Users

curl -X GET \
  'http://localhost:8080/api/users?key_word={keyWord}&page={page}' \
  -H 'Authorization: Bearer {accesstoken}' \

#### {keyWord} palavra chave para procurar usuarios. Obrigatoria
#### {page} numero da pagina da busca. 0 based. Default :0
#### {accesstoken} access token gerado no endpoint get token 


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

