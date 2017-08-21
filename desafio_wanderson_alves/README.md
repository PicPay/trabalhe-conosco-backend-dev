# Teste Backend

Aplicação Backend desenvolvida usando a tecnologia .NET Core 1.1, a API foi dividida em camadas sendo: API, Application, Domain, Data e Configuration para facilitar o desenvolvimento e futuras modificações.

Para interagir com as funções disponibilizados pela API foi criado um Front-End usando a tecnologia Angular 4.x com o Framework Materialize mais informações http://materializecss.com/.

# Teste - Backend

Login: Para realizar o teste de simulação de autenticação basica, acesse a rota http://localhost:3000/api/login e através de um Post envia o Json {UserName: "USE_NAME"}, o user name pode ser qualquer existente no arqvivo users.csv.
User: Lista os usuários contido no arquivo users.csv, as ações de listar e filtra usuários é de responsabilidade da rota http://localhost:3000/api/user/{page:int}/{pageSize:int}/{search?}, através de uma requisição Get pode ser obtido os usuários
filtrado por página e quantidade de registro por página e por uma string que buscar por nome ou user name.


# Para tentar menhorar o desempenho optei em criar um cache com todos os dados do arquivo csv, quando a aplicação for iniciada os registros são guardados em cache,
no dotnet core existe uma classe que só é iniciada quando a aplicação é iniciada pela primeira vez a classse Startup.cs, então como ela só é executada quando
a aplicação for levantada foi eleita para realizar a carga em memória. Fiz o desenvolvimento da classe Cache.cs para isolar as regras de cache em um unico lugar essa classe
é inicida uma unica vez na primeira vez que a aplicação é iniciada pois é um Singleton. Para a manipulação dos dados criei as classe de Repositórios onde através da biblioteca Linq
realizo ações de seleção nos dados. 

