![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Teste Backend - Solução

Para a resolução do problema proposto utilizei o framework Spring Boot e a IDE Eclipse. Utilizei o banco MySql e no frontend fui auxiliado pelo bootsrap.


### Docker

Ainda estou trabalhando para automatizar a criação da imagem do server MySql com a importação dos arquivos. Até o momento conclui apenas o levantamento inicial do servidor apenas (sem a importação dos dados).

Como o MySql não possui um comando para facilitar essa importação (como o 'COPY "table" FROM "file" CSV' do Postgres), esta etapa está pendente até o momento.

Meu Dockerfile ainda está em construção, mas por enquanto ficou assim:

```
FROM ubuntu
RUN apt-get update -y
RUN apt-get install apt-utils -y
RUN apt-get install mysql-server -y
RUN echo "chmod -R 755 /var/lib/mysql/" >> ~/.bashrc
RUN echo "service mysql start" >> ~/.bashrc
RUN chmod -R 755 /var/lib/mysql/
RUN echo "[mysql]" >> /etc/mysql/mysql.cnf
RUN echo "bind-address = 0.0.0.0" >> /etc/mysql/mysql.cnf
```

- O comando para criar a imagem no docker é: "docker build -f Dockerfile -t <name>/my_ubuntu ."
- E para rodar rodar o container é: "docker run -it -p 3306:3306 <name>/my_ubuntu"

- Na primeira execução do container (também tentarei automatizar isso), será necessário executar o seguinte comando para dar permissão para o usuário root:
echo "GRANT ALL ON *.* TO root@'%' IDENTIFIED BY 'root' WITH GRANT OPTION; FLUSH PRIVILEGES" | mysql -u root -p


### Rodando o Projeto

- Como foi utilizado o Spring Boot para o projeto, basta fazer o clone do código e importa-lo no Eclise (File -> Import -> Existing Maven Projects).
- Após importar, clique com o botão direito na classe ApplicationStart e Run As -> Java Application. O próprio Spring Boot irá se encarregar de publicar a aplicação no tomcat.


### Acesso:

Através da URL: http://localhost:8080 é possível acessar uma página com 2 campos para login e senha. Utilize os seguintes dados:

- Usuário: picpay e Senha: test123

Foi utilizado Basic Autentication com os usuários habilitados na memória do servidor. Mas tanto a alteração de tipo (para formulário por exemplo) quanto para a validação (no banco por exemplo) podem ser implementados sem grandes dificuldades na classe SecurityConfig, localizada no pacote security.

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