O processo de confecção da solução teve como princípios os conceitos de separação de responsabilidades, DDD e TDD. Isso fez com que o sistema ficasse com 87,8% de cobertura de código.

Inicialmente realizou-se a migração dos usuários presentes do arquivo CSV para uma base relacional (H2). Essa migração passou por problemas sérios de desempenho. Tanto que, no melhor cenário, as previsões de término da migração seriam de 19h após seu início. Tomei então a decisão de utilizar o MongoDB, e após alguns testes visando performance no desempenho, chegou-se ao máximo de 50 minutos de tempo de migração. O código utilizado para essa tarefa encontra-se na classe CarregadorDeBase (que contém um método main) e demais classes auxiliares.

Após a migração, realizei a escrita de código para a solução, efetivamente. 

Busquei atingir os seguintes diferenciais:

 * desempenho;
 * utilização do Docker;
 
 Para isso, foi necessário estudar as formas de indexação de documentos oferecidas pelo MongoDB. Inicialmente tentei utilizar indexação composta simples, que fez com que o desempenho das consultas levasse em torno de 15 segundos. Depois tentei indexação simples nos campos username e nome, separadamente. O desempenho ficou excelente para buscas exatas (onde a palava-chave é exatamente igual ao username ou ao nome) mas continuou ruim para outras formas de consulta. Por último, utilizei o índice por wildcard, da seguinte forma:
 
 db.usuarios.createIndex({"$**": "text"})
 
e fiz com que o UsuariosService fizesse a busca na base de acordo com a palavra-chave utilizada, com base nos padrões de usuário e username. Todas essas alterações fizeram com que tanto buscas por palavras exatas quanto por parte das palavras levasse entre 1 e 4 segundos. A aplicação em si está realizando sua tarefa de forma muito rápida, sendo o gargalo, portanto, no banco.
 
 por último, incluí um plugin do maven (que já utilizei em outras empresas) para geração de imagem docker.
 
 Outras informações importantes:
 
  * utilizei a ferramenta lombok para escrever menos código. É necessário instalá-lo na IDE onde o sistema for aberto. Para entender seu funcionamento, bem como instalá-lo na IDE acesse o link http://blog.caelum.com.br/java-menos-verboso-com-lombok/ 
  * um exemplo de busca: http://localhost:8080/usuarios/diether.be/pagina/0 onde diether.be é a palavra chave, e o 0 (zero) é a página

 
 
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

