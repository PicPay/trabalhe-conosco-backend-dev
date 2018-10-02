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

- Criar um frontend para realizar a busca com uma UX elaborada.
   - Não elaborei um frontend, mas possuo experiẽncia em html5, css3 e javascript, bem como de frameworks relacionados.
   - Trabalho há pelo menos 10 anos com Java Server Faces (JSF) Facelets e PrimeFaces.

- Criar uma solução de autenticação entre o frontend e o backend.
   - Devido a não criar o frontend também deixei sem autenticação, mas aqui seria o caso de criar os usuários que poderiam buscar na plataforma, guardar a informação cifrada na sessão da aplicação cliente e passá-la nas requisições para verificação da API

- Ter um desempenho elevado num conjunto de dados muito grande - ok (na primeira execução ele estará abrindo pela 1ª vez a conexão e efetuando alguns caches, sendo um pouco demorado, mas depois será notado uma resposta bem rápida)
- Utilizar o Docker - ok

### Como efetuar o teste

- 1
    - Criar a imagem do postgres colocando os arquivos: users.csv (baixado pelo link), modelo.sql e Dockerfile (no diretório postgres do projeto) em um diretório específico da máquina host.
    - Entrar no diretório criado e executar o comando: "docker build -t postgres-picpay-user:1.0 .".
    - O docker criará a imagem postgres-picpay-user com a tag 1.0 a partir da imagem oficial do postgres.
    - A imagem será preparada para criar um schema chamado "picpay" na criação do contêiner e também serão criadas as tabelas, assim como, ocorrerá a importação do arquivo csv.
    - Para criar o contêiner execute o comando: "docker run --name dbtest -e POSTGRES_PASSWORD=picpay -d -p 5432:5432 postgres-picpay-user:1.0"
        - Atenção: este processo será bem demorado visto que o container estará importando o arquivo csv. Pode ser verificado o andando rodando o comando "docker exec [containerID] ps aux|grep postgre". A saída do comando ps mostrará o processo responsável pela cópia dos dados. Continue verificando a saída do comando até que o processo não apareça mais, indicando seu término de execução. 

- 2 
    - Criei uma imagem no docker hub para o Application Server com a aplicação implantada e tudo configurado. Basta seguir os passos a seguir para montar o ambiente para o teste.

## Baixar a imagem do Wildfly

- sudo docker pull rodrigopim/wildfly-admin-jdbc-postgresql

## Criação do contêiner

- sudo docker run -p 8080:8080 -p 9990:9990 -it --name appServer rodrigopim/wildfly-admin-jdbc-postgresql

## Configurações adicionais (comunicação entre os contêineres)

- sudo docker network create --driver=bridge wildfly-network-postgresql
- sudo docker network connect wildfly-network-postgresql dbtest
- sudo docker network connect wildfly-network-postgresql appServer

## Agora basta acessar o navegador indicando o caminho:

hhtp://localhost:8080/ApiRestTestPicPay-1.0-SNAPSHOT/ e seguir a orientação de uso.