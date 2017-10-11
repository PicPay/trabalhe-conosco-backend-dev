![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Desafio concluído
### Tecnologias:
SpringBoot, Spring MVC, Spring Data, Spring Security
JWT ( Usado na segurança com tokens )
Flyway ( Migração )
MySql
Angular
Primeng ( Biblioteca de componentes para angular )
Tomcat ( Back-end - embutido no Spring boot )
Node.js (Front-end)

### Ferramentas:
STS ( Spring Tool Suite )
Workbench ( SGBD )
Visual Code
Angular CLI

Infelizmente não tive tempo para usar Docker neste projeto.
Mas pensando no tempo de vocês, eu subi a API no Heroku, porem como minha conta é grátis, todos os recursos são bem limitados. Então consegui inserir muitos usuários. A tabela contem apenas  68 registos de usuário. Não há como testar performance, mas todo o resto você consegue testar, inclusive a parte de autenticação verificando os cookies.  Mais abaixo explicarei como rodar a API, caso queiram testar tudo.
Antes de acessar a API você deve saber que a politica do Heruko para constas grátis (meu caso). Na politica diz que se a aplicação ficar 30 minutos sem requisição a aplicação dormi, e na próxima requisição todo o sistema é iniciado. Podendo levar cerca de 1 minuto para iniciar, e enquanto isso pode ocorrer erros por conta de estabilidade.
Link: https://rafael-macedo-ui.herokuapp.com/
Usuário: macedoorafael@gmail.com
Senha: carro

## Backend
##### Rodar o PicPay-api (backend)
1)	Clone em: https://github.com/macedorafael/trabalhe-conosco-backend-dev.git
2)	Entre na  pasta Back-End
3)	Faça o build executando o seguinte comando: mvn clean install
4)	Verifique se seu computador contem o MySql instalado.
5)	Vá até a pasta target do projeto e execute o seguinte comando: java -jar picpay-api-1.0.0-SNAPSHOT.jar --spring.datasource.name=root spring.datasource.password=root --picpay.origin.oringin-allow=http://localhost:4200 --spring.profiles.active=oauth-security . Lembrando que são parâmetros que você terá que inserir com base do computador local. Flyway será responsável por criar a base, as tabelas e quase todos os dados.
6)	Em um SGBD de sua escolha pegue o arquivo .csv fornecido por vocês e o importe na tabela users.
A parte interessante o backend foi a implementação da autenticação e autorização com Oauth2. 
Na primeira vez que o usuário faz o login no sistema é fornecido um token e um refresh-token, sendo que o token expira em 20 segundos, e com o refresh token no cookie o usuário ganha outro token com mais 20 segundos, caso o atual a esteja expirado. Claro isso tudo é transparente para o usuário.

  
Caso queiram testar no Postman ou em outra ferramenta semelhante, segue os dados necessários. 
Para solicitar o token será necessário informar o usuário e senha do cliente da api.
Login: admin
Senha: pwd
Content-Type: application/x-www-form-urlencoded
Usuário do sistema: macedoorafael@gmail.com
Senha do usuário do sistema: carro
URI para a solicitação: http://localhost:8080/oauth/token
Fazendo a requisição com sucesso será retornado o token e você verá na aba de cookie um novo cookie chamado refreshToken.

##### Base de dados
Com certeza uma base de dados noSql  como REDIS e MongoDB a pesquisa seria muito mais rápida ( aliás, olhando a aparência dos identificadores dos dados de dentro do arquivo .csv fornecido por vocês, eu diria que foi exportado de uma base noSql), porem eu quis ver por mim mesmo o quanto a tabela do tipo MyISAM é velos, pois em um curto tempo que fiz uma POC junto a um recurso da Oracle, ele me disse que esse tipo de tabela é muito rápido, mas na minha opinião deixou a desejar.
Caso queiram testar apenas a query que retorna os usuários segue os passos:
1)	Crie uma base no MySQL
2)	Vá ate o projeto Pic-Pay-api e entre na pasta PicPay-api/src/main/resources/db/migration 
3)	Execute no MySQL o conteúdo do arquivo V02_create_users.sql
4)	Execute no MySQL o conteúdo do arquivo V05__create_and register_priority.sql
5)	Importe para a tabela users os dados do usuário fornecido por vocês.
6)	 Rode a query abaixo

select id AS id, name AS name, username AS username 
    from (                    
	select                                                                          
		case                                                                            
		when priority is null then 3                                                
		else priority                                                               
		end as priority,                                                                
	s.id AS id, s.name AS name, s.username AS username                              
	from users s                                                                    
	left join (                                                                     
	select id_users as id_user, priority as priority from priority              
	) p on p.id_user = s.id  where s.name like "%test%" or s.username like "%test%"  		     
) p order by priority LIMIT 0,15


#####Rodar o picpay-ui (frontend)
1)	Clone em: https://github.com/macedorafael/trabalhe-conosco-backend-dev.git
2)	Com o Node.js instalado, digite no console: ng build –prod
3)	Rode o Node.js digitando: node server.js
4)	Acesse a URL localhost:4200

Usuário: macedoorafael@gmail.com
Senha: carro




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

Faça um ***Fork*** deste repositório e abra um ***Pull Request***, **com seu nome na descrição**, para participar.

-----

### Diferenciais

- Criar um frontend para realizar a busca com uma UX elaborada
- Criar uma solução de autenticação entre o frontend e o backend
- Ter um desempenho elevado num conjunto de dados muito grande
- Utilizar o Docker

