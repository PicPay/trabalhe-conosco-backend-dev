![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Desafio back-end PicPay

## Getting Started
Uma aplicação Node.js RESTful com MongoDB .
Essas instruções fornecerão uma cópia do projeto em funcionamento em sua máquina local para fins de desenvolvimento e teste.

A aplicação está dockerizada, possui uma interface com usuário (responsiva), autenticação. Para otimização dos resultados, inseriu-se um novo campo no banco de dados, contendo as keywords extraídas de cada usuário, definidas por uma lista de strings. Segundo a documentação do MongoDB, essa solução apresentaria um bom desempenho para uma quantidade de grande de dados.

Definiu-se que os delimitadores de keywords seriam apenas '.'(ponto) e ' ' (espaço em branco). Removeu-se as keywords que seriam repetidas, antes da inserção no banco, por exemplo: name: Joao Silva Santos, username:joao.silvasantos, para esse usuário as keyword são ["joao","silva","santos","silvasantos"].

### Prerequisites
Esta aplicação foi homologada utilizando as versões:
```
Docker version 17.05.0-ce, build 89658be
docker-compose version 1.14.0, build c7bdf9e
```

### Installing

Foram definidos dois métodos de deploy:
   - Instalação rápida. Imagens Docker serão baixadas com o banco de dados já incluso e indexado, pronto pra uso.
   - Instação completa. Neste processo, serão gerados os containers da aplicação web e do bd. Um container intermediário fará o download do arquivo users.csv e alimentará o container de BD, que por sua vez fará a indexação dos dados para otimizar a busca. Tanto a aplicação quanto o BD terão seus dados persistentes armazenados em volumes. Este modo pode levar um tempo considerável para ser instalado, dependendo do hardware (Testei em 3 máquinas diferentes que apresentaram os tempos  de ~40min, ~1h10min e ~2h). Vale ressaltar que esse processo só ocorrerá na PRIMEIRA execução, após isso, o tempo de deploy é irrelevante.

#### Fast deploy

Instação rápida:
```
make easy_install
```

Caso não queria  utilizar o docker-compose, é possivel subir a aplicação de maneira rápida (volumes de BD e web já inclusos), através dos dois comandos abaixo:
```
docker run -d --name app_mongodb mateusvtt/mongo_populated
docker run -d --name app_web -p 3000:80 --link app_mongodb mateusvtt/nodejs-ready
```
Ou através do Makefile:
```
make docker_run
```
#### NetInstall
Esse processo é o mais demorado, entretanto segue as boas práticas, baixando as imagens nativas, e fazendo todos downloads necessários (users.csv e bibliotecas JS), importação e indexação de banco de dados. Os dados persistentes ficam mapeados em voluemes e somente o necessário é versionado, tornando a aplicação enxuta.

```
make full_install
```
Único pré-requisito para a instalação completa funcionar é que o users.csv.gz ainda esteja hospedado no link fornecido. A aplicação fará download do mesmo e eralizará a importação.

*Caso preferir, é possível também deixar o arquivo disponível em ./volumes/mongo-seed/users.csv (esse diretório é gerado pelo container mongo-seed, se a aplicação não foi iniciada ainda, ele não existirá, mas o usuário pode criá-lo sem problemas). Também é aceito o arquivo compactado no formato .gz.*

Durante o processo de instalação completa, na inicialização, o container web irá aguardar o container de alimentação do banco de dados (mongo-seed). Terminando a importação, a aplicação já ficará disponível na porta 3000. Porém, agora é a vez do container de BD analisar os dados e indexá-los para otimização dos resultados. A aplicação indicará que esse processo está e execução, por meio de tela de loading. Ao fim desta etapa, a mesma ficará 100% disponível e o usuário será redirecionado para a página de login.

Ao fim da importação já é possível acessar a aplicação pela url http://localhost:3000 . Essa página tem um auto-refresh, assim que o BD estiver preparado o usuário será redirecionado:
![loading_page](https://image.ibb.co/m8FVu5/Screenshot_from_2017_08_21_00_22_14.png)

Fim de indexação das keywords, abrirá a tela de login:

![login_page](https://image.ibb.co/mAZOE5/Screenshot_from_2017_08_21_00_15_14.png)

## API

Antes de executar a API, caso esteja utilizando a versão que faz todo processo de instalação, certifique-se que a indexação foi concluída. Através  da url http://localhost:3000 , caso seja redirecionado para a tela de login, tanto a API quanto a aplicação web já estarão prontas pra uso. Também é possível realizar essa checagem, coferindo se o arquivo indexed.lock foi criado em ./volumes/app. Caso ele não esteja, haverá o arquivo index_tags.lock, no mesmo diretório, que indica que o processo está em andamento.

Para realizar consultas por meio da api, utilize a serguinte url: http://localhost:3000/users/api/\<pagina\>/\<query\>

Como foi solicitado que fossem mostrados apenas 15 elementos por resposta, a variavel 'pagina' serve para indicar a página desejada.
```
http://localhost:3000/users/api/1/joao

Resposta:
{"docs":[{"_id":"599a315cc0d985703eaebeb7","id_sec":"a4f75de3-b2c3-4731-95c8-9a90fc77cd44","name":"Joao Santhiago","username":"joaosanthiago","lista1":0,"lista2":0,"id":"599a315cc0d985703eaebeb7"},{"_id":"599a315cc0d985703eaec1e2","id_sec":"7412c43f-332c-4009-90c6-868a716841bc","name":"joao Bridi","username":"joao.bridi","lista1":0,"lista2":0,"id":"599a315cc0d985703eaec1e2"},{"_id":"599a315cc0d985703eaec8a9","id_sec":"1abab56f-733b-4116-bb6a-cdd62eb6aa12","name":"joao Pastana","username":"joao.pastana","lista1":0,"lista2":0,"id":"599a315cc0d985703eaec8a9"},{"_id":"599a315cc0d985703eaecabf","id_sec":"4dbd068f-5381-4d47-a7f6-86bce9ef5716","name":"Jacirlane Joao","username":"jacirlanejoao","lista1":0,"lista2":0,"id":"599a315cc0d985703eaecabf"},{"_id":"599a315cc0d985703eaed7ec","id_sec":"d8d6842c-99eb-412c-bdfa-e60753861ba7","name":"Joao Rejane","username":"joao.rejane","lista1":0,"lista2":0,"id":"599a315cc0d985703eaed7ec"},{"_id":"599a315cc0d985703eaed82d","id_sec":"83117c42-c719-48f3-b7ce-8eec7b87444f","name":"Joao oliveira Pierroni","username":"joao.oliveira.pierroni","lista1":0,"lista2":0,"id":"599a315cc0d985703eaed82d"},{"_id":"599a315cc0d985703eaedc8c","id_sec":"61a01348-f3ea-4d56-8dd5-2327f22f93a1","name":"Valmir Joao Andrew","username":"valmir.joao.andrew","lista1":0,"lista2":0,"id":"599a315cc0d985703eaedc8c"},{"_id":"599a315cc0d985703eaeeaeb","id_sec":"2a54be6b-6e62-4cbb-b019-603e85fc59b1","name":"joao Cintia","username":"joao.cintia","lista1":0,"lista2":0,"id":"599a315cc0d985703eaeeaeb"},{"_id":"599a315cc0d985703eaeec74","id_sec":"a36e3819-18bb-43b3-bb02-dd2b3480add7","name":"joao Sfalcin","username":"joao.sfalcin","lista1":0,"lista2":0,"id":"599a315cc0d985703eaeec74"},{"_id":"599a315cc0d985703eaef1b3","id_sec":"fff6c423-8774-4200-85e6-879c7e622678","name":"Joao Anny","username":"joaoanny","lista1":0,"lista2":0,"id":"599a315cc0d985703eaef1b3"},{"_id":"599a315cc0d985703eaef1c2","id_sec":"a85987c7-3661-4b06-8c98-b7408692159a","name":"Kenno Joao Oliverio","username":"kenno.joao.oliverio","lista1":0,"lista2":0,"id":"599a315cc0d985703eaef1c2"},{"_id":"599a315cc0d985703eaef2ac","id_sec":"447048bb-b24f-47ab-aa65-2b52860ff7cd","name":"Joao Alexsander Leonardo","username":"joao.alexsander.leonardo","lista1":0,"lista2":0,"id":"599a315cc0d985703eaef2ac"},{"_id":"599a315cc0d985703eaef335","id_sec":"e2fdd551-0da2-43cd-862a-6fd78da326fe","name":"joao Vasco Fraife","username":"joao.vasco.fraife","lista1":0,"lista2":0,"id":"599a315cc0d985703eaef335"},{"_id":"599a315cc0d985703eaefbe9","id_sec":"d8f68dfd-fa8f-4b54-89fc-329762e0b9d0","name":"joao Januario","username":"joao.januario","lista1":0,"lista2":0,"id":"599a315cc0d985703eaefbe9"},{"_id":"599a315cc0d985703eaf006f","id_sec":"86654cf4-fe2a-4d2a-9a64-6562382bbb8f","name":"Leila Joao","username":"leila.joao","lista1":0,"lista2":0,"id":"599a315cc0d985703eaf006f"}],"total":8169,"limit":15,"page":1,"pages":545}

```
![api_page](https://image.ibb.co/b9UZMk/Screenshot_from_2017_08_21_00_18_03.png)


A resposta obedece o formato {docs:[],total:x,limit:15,page:y,pages:z}
Em 'docs' estarão a lista de objetos encontrados, com nome, username, id e lista1 e lista2 que indicam se determinado usuário pertence a uma lista de relevância.

Embora seja criado um campo no BD chamado tags para indexação das keyowords, optou-se por não retorná-los na API.

O atributo 'total' representa a quantidade de usuários encontrados, 'limit' é o limite da paginação, 'page' a página atual e 'pages' a quantidade total de páginas para o determinado limite. Os demais são os identificadores inseridos pelo MongoDB.

## Interface WEB
Assim que o usário já tiver sido cadastrado ele se torna apto a realizar buscas via navegador.

http://localhost:3000

A interface oferece a opção de aplicar o operador AND nas palavras inseridas, e também o operador OR.
Basta inserir as palavras que se deseja buscar e separá-las utilizando espaço que a tag irá aparecer.

Exmplo: Buscar usuários que satisfazem as palavras João e José

![search_page](https://image.ibb.co/fGkGj5/Screenshot_from_2017_08_20_21_31_45.png)

No rodapé da tabela é possível pular para uma determinada página. Basta inserir o número no campo de input e clicar no avião.

As listas de relevância dão prioridade as buscas, tanto na api quanto na interface. A lista1 tem preferência em relação a lista2. Na imagem abaixo foram combinadas 3 tags com o operador OU e podemos observar os indicadores de listas:

![search2_page](https://image.ibb.co/c1G3E5/Screenshot_from_2017_08_21_00_19_12.png)
