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

Esta é uma implementação básica de API REST com Clojure e Lucene.

Clojure foi escolhido devido a sua praticidade e Lucene pelo alto desempenho em pesquisas envolvendo grande volume de dados.

#### Dockerfile

Na pasta do projeto tem um arquivo Dockerfile responsável por construir e executar a aplicação.

Você pode executar o Dockerfile com os seguintes comandos:

    $ docker build -t picpay/backend-test .

    $ docker run --rm -p 8088:8080 picpay/backend-test

O primeiro comando faz o download do arquivo de usuários e de outros projetos que este projeto depende, cria um jar, e então uma imagem docker com esse jar. O segundo comando cria o container e inicializa o servidor na porta externa 8088.

#### Sem Docker

Para rodar a aplicação sem Docker você precisa ter:

- Clojure
- Leiningen
- O arquivo users.csv na pasta resources.

Então digite o comando:

    $ export PORT=8080 && lein run

E acesse http://localhost:8080/?name=bruna&page=0

#### Notas

- O processo de indexação leva alguns minutos (~10 minutos no meu Macbook Air 2011).
- Os índices são armazenados na pasta de arquivos temporários do sistema.
- Eu testei 3 maneiras de processar o arquivo.
  - Processamento “preguiçoso”: Consome o arquivo sem precisar carregá-lo todo na memória, mas gera coleções intermediárias que depois precisam ser reclamadas pelo GC.
  - Processamento transducer: Transducer é uma abstração introduzida na versão 1.7 da linguagem Clojure que permite processar dados combinando funções diretamente, sem gerar coleções intermediárias.
  - Processamento paralelo: A biblioteca core.async permite executar um pipeline transducer em paralelo. Isso pode ajudar na performance de trabalhos quando o gargalo é o processamento (CPU).

Como o gargalo identificado neste caso foi a criação dos índices pelo Lucene (IO), não foi usado processamento paralelo.

Depois de um tempo processando “preguiçoso”, foi observado que, de fato, o GC tende a ficar bastante ativo, reduzindo a performance geral da JVM.

Por esse motivo eu optei por usar transducer.
