# Desafio PicPay

Tecnologias utilizadas no backend:

  - Framework PHP Symfony 4 - https://symfony.com/
  - Autenticação da API REST com JWT - https://jwt.io/
  - ORM Doctrine com MySql - http://www.doctrine-project.org/
  - Cacheamento com Redis - https://redis.io/
  - Second Level Cache do Doctrine - http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/second-level-cache.html
  
Sobre o Second Level Cache do Doctrine, funciona como um banco de dados intermediário em cache. Quando habilitado, os dados da consulta feita pelo Doctrine serão procurados primeiramente no cache, e caso encontre os dados, eles são recuperados e nenhuma transação no mysql é feita, aumentando bastante a perfomance. O cache foi programado para ser armazenado de acordo com os parâmetros query string da url. Então conforme for navegando, esses parâmetros formam o identificador do cache, e o carregamento fica mais rápido a partir do segundo acesso a essa url. Todo cache foi configurado para ser gerenciado pelo Redis e esta funcionalidade só está disponível no modo produção.

Tecnologias utilizadas no frontend:

  - Angular 5 - https://angular.io/
  - Bootstrap 4 - http://getbootstrap.com/

Docker:

  - Laradock - http://laradock.io/

### Docker

Iniciando containers:

```sh
$ cd laradock
$ docker-compose up -d nginx mysql redis
```

### Configurações Iniciais

Adicione nos hosts do seu sistema operacional:

```sh
127.0.0.1  picpay-backend.local
127.0.0.1  picpay-frontend.local
```

Na raíz do projeto coloque o arquivo **users.csv** proposto pelo desafio.

### Instalação Backend Modo Produção

Altere o arquivo .env localizado raiz da pasta backend:

```sh
APP_ENV=prod
```

Com os containers em execução do docker, rode os seguintes comandos:

```sh
$ cd laradock
$ docker-compose exec workspace bash
$ cd /var/www/backend
$ composer install --no-dev --optimize-autoloader
$ php bin/console app:install --install-mode=prod
```

### Instalação Backend Modo Desenvolvimento

Altere o arquivo .env localizado raiz da pasta backend:

```sh
APP_ENV=dev
```

Com os containers em execução do docker, rode os seguintes comandos:

```sh
$ cd laradock
$ docker-compose exec workspace bash
$ cd /var/www/backend
$ composer install
$ php bin/console app:install --install-mode=dev
```

### Instalação Frontend

```sh
$ cd laradock
$ docker-compose exec workspace bash
$ cd /var/www/frontend
$ npm i
$ ng build --prod --build-optimizer
```

### Acessando a aplicação:

No seu navegador acesse: http://picpay-frontend.local:8010

Usuário: neandher89@gmail.com

Senha: 1234

A URL de requisição a api é: http://picpay-frontend.local:8010/api

**Obs:** Não foi solicitado no desafio, mas faltou implementar na API REST testes com o PHPUnit e adicionar uma documentação para a mesma.
