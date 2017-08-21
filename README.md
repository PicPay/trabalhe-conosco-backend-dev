![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Desafio back-end PicPay

## Getting Started
Uma aplicação Node.js RESTful com MongoDB .
Essas instruções fornecerão uma cópia do projeto em funcionamento em sua máquina local para fins de desenvolvimento e teste.

A aplicação está dockerizada, possui uma interface com usuário (responsiva), autenticação e para otimização dos resultados inseriu-se um novo campo no banco de dados, contendo as keywords extraídas de cada usuário.
### Prerequisites
Esta aplicação foi homologada utilizando as versões:
```
Docker version 17.05.0-ce, build 89658be
docker-compose version 1.14.0, build c7bdf9e
```

### Installing

Foram definidos dois métodos de deploy:
   - Instalação rápida. Imagens Docker serão baixadas com o banco de dados já incluso e indexado, pronto pra uso.
   - Instação completa. Neste processo, serão gerados os containers da aplicação web e do bd. Um container intermediário fará o download do arquivo users.csv e alimentará o container de BD, que por sua vez fará a indexação dos dados para otimizar a busca. Tanto a aplicação quanto o BD terão seus dados persistentes armazenados em volumes. Este modo pode levar algum tempo para ser instalado, dependendo do hardware. ~ 30 - 60 min. Vale ressaltar que esse processo só ocorrerá na PRIMEIRA execução, após isso, o tempo de deploy é irrelevante.


Instação rápida:
```
make easy_install
```

Instalação completa:
```
make full_install
```
Durante o processo de instalação completa, na inicialização, o container web irá aguardar o container de alimentação do banco de dados (mongo-seeed). Terminando a importação a aplicação já ficará disponível na porta 3000. Porém, agora é a vez do container de BD analisar os dados e indexá-los para otimização dos resultados. A aplicação indicará que esse processo está e execução, por meio de tela de loading. Ao fim desta etapa, a mesma ficará 100% disponível e o usuário será redirecionado para a página de login.

Ao fim da importação a aplicação fica disponível:
![loading_page](https://image.ibb.co/mY4945/Screenshot_from_2017_08_20_21_31_01.png)

Fim de indexação das keywords:
![login_page](https://image.ibb.co/hnmQBk/Screenshot_from_2017_08_20_21_52_45.png)

## API

Confira se a indexação já foi concluída, através pagina da url http://localhost:3000 , caso seja redirecionado para a tela de login, tanto a API quanto a aplicação web há estarão prontas pra uso. Também é possível realizar essa checagem, coferindo se o arquivo indexed.lock foi criado em ./volumes/app. Caso ele não esteja, haverá o arquivo index_tags.lock, no mesmo diretório, que indica que o processo ainda não terminou.

Para realizar consultas por meio da api, utilize a serguinte url: http://localhost:3000/users/api/<pagina>/<query>

Como foi solicitado que fossem mostrados apenas 15 elementos por resposta, a variavel 'pagina' serve para indicar a página desejada.
```
http://localhost:3000/users/api/1/joao

Resposta:


```
![api_page](https://image.ibb.co/bPstxQ/Screenshot_from_2017_08_20_21_59_46.png)


A resposta obedece o formato {docs:[],total:x,limit:15,page:y,pages:z}
Em 'docs' estarão a lista de objetos encontrados, com nome, username, id e lista1 e lista2 que indicam se determinado usuário pertence a uma lista de relevância.

Embora seja criado um campo no BD chamado tags, para indexação das keyowords, optou-se por não retorná-los na API.

Os demais dados: 'total' representa a quantidade de usuários encontrados, 'limit' é o limite da paginação, 'page' a página atual e 'pages' a quantidade total de páginas para o determinado limite.

## Interface WEB
Assim que o usário já tiver sido cadastrado ele se torna apto a realizar uscas via browser.
http://localhost:3000
A interface oferece a opção de aplicar o operador AND nas palavras inseridas, e também o operador OR.
Basta inserir as palavras que se deseja buscar e separá-las utilizando espaço.

Exmplo: Buscar usuários que satisfazem as palavras João e José

![search_page](https://image.ibb.co/fGkGj5/Screenshot_from_2017_08_20_21_31_45.png)

No rodapé da tabela é possível pular para uma determinada página. Basta inserir o número no campo de input e clicar no avião.

As listas de relevância dão prioridade as buscas, tanto na api quanto na interface. A lista1 tem preferência em relação a lista2. Na imagem abaixo foram combinadas 3 tags com o operador OU e podemos observar os indicadores de listas:

![search2_page](https://image.ibb.co/kW8SP5/Screenshot_from_2017_08_20_21_45_39.png)
