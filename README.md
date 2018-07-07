# Tecnologias
* [Jquery](https://jquery.com/)
* [Bootswatch](https://bootswatch.com/)
* [CodeIgniter 3](https://codeigniter.com/)
* [Imagem Docker Xampp](https://hub.docker.com/r/garland/xampp-base/)

# Requisitos 

- ***Docker*** 
- ***Docker Compose*** 
- Ter a porta 3737 do host livre (pode mudar em docker-compose.yml) 

# Observações 
Separei a instalação em duas etapas, com o objetivo de acelerar o processo de instalação. 

-A etapa 1 consiste em subir a aplicação já pronta para a visualização e funcionando, porem 
as requisições serão lentas, pois a tabela onde foi exportado os dados de **users.csv** não foram aplicados os indices.

-A etapa 2 consiste em exatamente realizar o procedimento de criar uma tabela com indices, após instalar a aplicação e acessar no browser http://127.0.0.1:3737 siga as instruções da tarja de notificação, que irá aparecer no topo para concluir com a segunda etapa. 

# Rodar a aplicação 
clone o repositório, navegue até a pasta pelo terminal, execute: 
``` 
./init.sh 
``` 
obs: poderá economizar um tempo evitando que a instalação realize o download do arquivo ***users.csv.gz***, cole manualmente dentro da pasta ***app/db***, economize mais tempo ainda colando o arquivo já extraído, assim init.sh irá pular o download e a extração ^ ^. 

# Sobre init.sh 
- ira subir nosso container docker através do docker-compose
- iniciar o xampp 
- copiar as listas 1 e 2 para a pasta da aplicação 
- realizar o download do arquivo ***users.csv.gz*** 
- extrair ***users.csv.gz*** 
- criar/importar base de dados parte 1 

# Acessar a aplicação 
Após o terminal ser liberado, acesse http://127.0.0.1:3737 

Login: picpay

Senha: picpay

#

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

