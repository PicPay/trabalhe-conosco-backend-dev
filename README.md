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

# Resolução (por Marcos Angelo Molizane)

O teste foi desenvolvido com o stack em Docker e Docker compose, agregando:
* Apache 2.4
* PHP 7.2
* MySQL 5.7
* Shell script

### Montagem do sistema em ambiente local

Para executar a solução em ambiente local, basta ter instalado o [Docker](https://www.docker.com/products/docker-desktop), o [Docker compose](https://docs.docker.com/compose/install/) e fazer o clone deste repositório.

Após, acessar o diretório do repositório clonado e digitar:

```
docker-compose up
```


#### Executar as rotinas de ETL

Copiar os arquivos [users.csv.gz](https://s3.amazonaws.com/careers-picpay/users.csv.gz), [lista_relevancia_1.txt](lista_relevancia_1.txt) e [lista_relevancia_2.txt](lista_relevancia_2.txt) no diretório **_configs/database/**.

Executar no diretório raiz do projeto o comando: 
```
docker-compose up
```

Após o término de criação das imagens, dos contêiners e subida dos serviços, acessar o console do conteiner do MySQL e executar shell script para realizar e importação dos dados do arquivo "users.csv.gz" para o banco de dados, utilizando a sequência de comandos abaixo:
```
docker exec -e COLUMNS="`tput cols`" -e LINES="`tput lines`" -u 1000:1000 -ti [nome_do_conteiner_db] /bin/bash

cd docker-entrypoint-initdb.d/

./db.sh 2> db.log (Este processo levará algum tempo (entre 1:40 até 8:00) devido as mais de 8.000.000 linhas de registros para serem importados
```


#### Acessar o sistema

Adicionar a seguinte entrada no arquivo hosts (/etc/hosts) do computador (se Linux):
```
127.0.0.1 api.local
```

Abrir o navegador e acessar o endereço [http://api.local/user](http://api.local/user)

### Endpoints
| Rota                                           | Método | Resposta                                                                                                    |
|------------------------------------------------|--------|-------------------------------------------------------------------------------------------------------------|
| /user/                                         |  GET   | Lista completa com todos os registros (arriscado com cerca de 8.000.000 de registros)                                                                     |
| /user/[id:númerico]                            |  GET   | Recupera o registro com o id, formato numérico inteiro                                                                           |
| /user/[limite:númerico]/[offset:númerico]      |  GET   | Lista completa com todos os registros paginando denttro do "limite" (númerico inteiro) com "offset" (númerico inteiro) informados |
| /user/busca/[critério:texto]/[página:númerico] |  GET   | Lista com resultados da busca com critério (texto) na página (númerico inteiro) com até 15 itens por página         |

### Formato da resposta JSON
```
status:	200 [1]
type: "success" [2]
message: "ok" [3]
content [4]
    labels [5]	
        id: "ID"
        uuid: "UUID"
        nome: "Nome"
        username: "Username"
    results: 15 [6]
    page: 3 [7]
    data [8]
        0 	
            id:	71776
            uuid:	"f21957b0-c266-4f45-af12-d958dbd86ff9"
            nome:	"Heverly Ana"
            username:	"heverly.ana"
        ...
```

Onde:

| Código | Campo | Tipo             | Descrição                                 |
|--------|-------|------------------|-------------------------------------------|
|[1]     |status | Numérico inteiro |Informa a resposta utilizando código HTTP |
|[2]     |type   | Texto            |Informa se o resultado foi positivo (success) ou não (error) |
|[3]     |message| Texto            |Mensagem informativa sobre o status [1] retornado |
|[4]     |content| Array            |Agrega o conteúdo da mensagem retornada (dados) |
|[5]     |labels | Array texto      |Nome na tabela e nome amigável dos campos retornados, que podem ser utilizados no front end |
|[6]     |results| Numérico inteiro |Quantidade de resultados retornados |
|[7]     |page   | Numérico inteiro |Página atual |
|[8]     |data   | Array            |Lista com todos os resultados com seus respectivos nomes e valores |