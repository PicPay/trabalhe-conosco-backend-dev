# Teste Backend

### Tecnologias

Minha solução foi desenvolvida usando PHP com banco de dados MySQL no backend e no frontend utilizando HTML, JavaScript/JQuery e CSS. 
Procurei resolver o problema da forma mais simples, utilizando tecnologias conhecidas por mim.

###### Imagem 1

![APP](http://i.imgur.com/mueswT6.png)


###### Imagem 2

![APP](http://i.imgur.com/41Zb00b.png)


-----

### Diferenciais explorados

#### Autenticação 
Para autenticar o cliente, utilizei a estratégia de Token. 
1. Quando o cliente entra na página principal a API fornece um Token e o mantem vivo. 
2. Em toda requisição de pesquisa a API o Token é passado como um dos parâmetros.
3. No servidor é verificado se o Token ainda está vivo.

#### Performance
Para aumentar a performance das consultas realizadas no banco MySQL foi criada uma chave FULLTEXT entre com os campos Nome e Username da tabela de usuários. Na pesquisa foi utilizado a clausula WHERE comandos como MATCH e AGAINST.



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

Faça um fork deste repositório e abra um pull request para participar.

-----

### Diferenciais

- Criar um frontend para realizar a busca com uma UX elaborada
- Criar uma solução de autenticação entre o frontend e o backend
- Ter um desempenho elevado num conjunto de dados muito grande
- Utilizar o Docker

