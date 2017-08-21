# Teste Backend

Aplicação Backend desenvolvida usando a tecnologia .NET Core 1.1, a API foi dividida em camadas sendo: API, Application, Domain, Data e Configuration para facilitar o desenvolvimento e futuras modificações.

Para interagir com as funções disponibilizadas pela API foi criado um Front-End usando a tecnologia Angular 4.x com o Framework Materialize: http://materializecss.com/.

# Teste - Backend

Login: Para realizar o teste de simulação de autenticação basica, acesse a rota http://localhost:3000/api/login e através de um Post enviar o Json {UserName: "USE_NAME"}, o user name pode ser qualquer existente no arqvivo users.csv.

User: Lista os usuários contido no arquivo users.csv, as ações de listar e filtra usuários é de responsabilidade da rota http://localhost:3000/api/user/{page:int}/{pageSize:int}/{search?}, através de uma requisição Get pode ser obtido os usuários
filtrado por página, quantidade de registro da página e por uma string que buscar por nome ou user name. 

Para testar a API Rest via linha de comando execute o comando dotnet publish -o dist e depois dotnet UsersAPI.dll dentro da pasta dist criada, a aplicação vai rodar na porta 3000, podendo ser acessada http://localhost:3000, a porta 3000 foi definida na classe Program.cs. Uma outra alteranativa é publicar a aplicação no Visual Studio em alguma pasta de escolha e depois dentro da pasta criada executar dotnet UsersAPI.dll. 
Observação: para testar com o arquivo users.cs completo sugiro alterar o arquivo da pasta api_rest_dotnet_core/UsersAPI/UserAPI/SeedData/, pois o que coloquei lá é menor que o original.

Para testar a aplicação Web Angular, dentro da pasta do projeto userApp executer npm install e depois ng server a aplicação vai rodar na porta 4200, podendo se acessada http://localhost:4200, lembrando que se a API Rest .NET Core for executa via linha de comando a porta de comunicação entre o servidor com o cliente é 3000.

#Informações 

Para tentar menhorar o desempenho optei em criar um cache com todos os dados do arquivo csv, quando a aplicação for iniciada os registros são guardados em cache, no dotnet core existe uma classe que só é iniciada uma unica vez ao subir a aplicação, essa classse é a Startup.cs, então como ela só é executada quando a aplicação for levantada foi eleita para realizar a carga em memória. 
Fiz o desenvolvimento da classe Cache.cs para isolar as regras de cache em um unico lugar, essa classe é inicida uma unica vez pois é um Singleton. 

Para a manipulação dos dados criei as classe de Repositórios onde através da biblioteca Linq realizo ações de seleção nos dados. 
