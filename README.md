![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Processo Seletivo - Dev Backend - Vitor Carmo Vannuchi
---

### Introdução
Ferramenta criada com propósito no processo seletivo 2018 da empresa PicPay, o projeto contém uma parte Backend e um Frontend do qual se é possível usar todas funções pedidas pelo processo e um pouco mais. Diferentemente do que foi pedido nesse projeto algumas alterações foram feitas.

### Instalação
Acesse o diretório laravel dentro do root
```
cd laravel/
```
Dentro do diretório, execute o comando dockers, para colocar todas os 3 containers, app, web e db para serem executados e acessíveis.
```
docker-compose up -d
```
Após a execução sem problemas dos containers dockers, será necessário a criação artisan key
```
docker-compose exec app php artisan key:generate
```
Logo em seguida criaremos a estrutura da database MySQL usando o seguinte comando
```
docker-compose exec app php artisan migrate
```
---
##### Escolha entre metodo A ou B
O próximo passo pode ser feito de qualquer uma das duas formas, A ou B - A sendo manual e B automátizado
##### A
Após a migration da database se completar, será necessário fazer o seed da DB, porém antes será necessário importar a DB fornecida users.csv.gz, **NOTE que na tabela do mysql criada pelo migration, ID se autoincrementa, token é o primeiro valor do arquivo csv, name se coloca em name e username em username.**

##### B
No arquivo `laravel/database/seeds/DatabaseSeeder` descomente as linhas 22 e 23
de
```php
//        $this->call(CustomerTableSeeder::class);
//        $this->command->info('Customer table seeded!');
```
para
```php
        $this->call(CustomerTableSeeder::class);
        $this->command->info('Customer table seeded!');
```
Isso vai fazer com que Laravel baixe o arquivo users.csv.gz, descompacte-o e use o conteúdo para preencher a tabela customers
Com o arquivo fornecido, isso irá demorar um tempo considerável.
---
##### Continuando
Não importa qual dos métodos você usou acima, execute o comando para preencher a database com informação do score, isso vai fazer com que as tabelas relacionadas com o Score começem a ser preenchidas e calculados os scores
```
docker-compose exec app php artisan db:seed
```

Após preencher as tabelas, instale Passport
```
docker-compose exec app php artisan passport:install
```
A resposta do Passport irá fornecer uma token que será usada no POST para criar o primeiro user.
A este ponto o projeto já vai estar rodando no `localhost:80` porém antes de acessar o frontend, é necessário usar a API para criar o seu user.
No diretório /documentation/ se encontra um arquivo chamado API-1.0-PicPay.pdf que contém instruções nas chamadas para a API REST.

Seguindo as instruções
-   Crie um User
-   Faça Login
-   Obtenha a Bearer Token
-   Faça uma request de Customers com a Bearer Token

O Frontend funciona similar a API, use as credenciais do user criado pela request para acessar o frontend.
No Frontend encontrará 2 funções
- Search Customer: função que buscará os usuários de acordo com a query imposta e retorna 15 usuários por página
- List Management: Com o sistema de Score criado, pelo list management, é possivél administrar a lista de relevância 1 e lista de relevância 2. Também é possível ver qual usuário está em ambas as listas, assim tendo mais relevância que todos os outros.

##### Diferenciais Almejados
- Criar um frontend para realizar a busca com uma UX elaborada
- Criar uma solução de autenticação entre o frontend e o backend
- Ter um desempenho elevado num conjunto de dados muito grande
- Utilizar o Docker

### Notas Importantes
O projeto atual é levemente diferente do que foi pedido no desafio com os seguintes pontos:

#### Função Principal
**desafio:** Com uma palavra chave deve-se buscar nos campos de name e username os usúarios.

**entregue:** 3 Campos de busca (id(token), name e username), retorna os similares a todos os campos preechidos

#### Sistema de Lista
**desafio:** Lista 1 Mais Relevante que Lista 2 que é mais relevante que o resto, resutlado ordenado por relevância (l1 > l2 > resto)

**entregue:** Sistema de Score implementado usando a DB, Users listados em ambas as listas são mais relevantes que os da lista 1, que são mais relevantes que a lista 2, que são mais relevantes que o resto (l1el2 > l1 > l2 > resto)

#### Database Users
**desafio:** Tabela user contêm: ID , Name e Username

**entregue:** Tabela User se chama: Customer, com colunas Token, Name e Username, onde ID virou Token


### Notas pessoais
Me arrisquei com algumas tecnologias novas que não era experiente 100%, consegui entregar algo que não é exatamente o ideal, porém faz o que foi pedido.
Caso tivesse que continuar com esse mesmo projeto, iria refazer a API para ter um sistema de response code mais estruturado, PHPUNIT em toda parte, padronização do código no MVC, entre outros.
Estou surpreso com o resultado que consegui, mesmo tendo em mãos uma lista de TO DO para um código mais SOLID e melhoramento da plataforma.



---
---
---


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

