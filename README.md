# Descrição

Docker utilizando o compose, arquivo de configuração com variáveis de ambiente, criando um container nginx 1.13.3 e um container php 7.1.9-fpm ligados através de um link e criando um container mysql 5.7.19.

Laravel versão 5.5.22

# Configuração Container Nginx

1. Exposição de portas

	80 e 443

2. Volume (Obs: verificar se na configuração do docker -> drivers compartilhados, as unidades c: e/ou d: estão habilitadas)

	Aplicação: htdocs -> /var/www/html
	
	Logs: nginx/logs -> /var/log/nginx
	
	Virtual Host: nginx/sites -> /etc/nginx/conf.d
	
3. Virtual Host

	Criação do vhost modelo http://api.dev (vhost modificável)

# Configuração Container Php

1. Exposição de portas

	9000

2. Volume (Obs: verificar se na configuração do docker -> drivers compartilhados, as unidades c: e/ou d: estão habilitadas)

	Aplicação: htdocs -> /var/www/html
	
3. Bibliotecas

	Habilitação de bibliotecas do php através de arquivo de configuração. Ex: MBSTRING, GD, MCRYPT, PDO_MYSQL, etc.
	
# Configuração Container Mysql

1. Exposição de portas

	3306

2. Volume (Obs: verificar se na configuração do docker -> drivers compartilhados, as unidades c: e/ou d: estão habilitadas)

	Aplicação: mysql/data -> /var/lib/mysql

3. Configuração para conexão

	- MYSQL_DATABASE      = default
	
    - MYSQL_USER          = default
	
    - MYSQL_PASSWORD      = secret
	
    - MYSQL_ROOT_PASSWORD = root
	
    - MYSQL_PORT          = 3306
	
# Como utitilizar

1. Clone o repositório usando o comando:

   git clone https://github.com/danielnogueira-dev/Docker-Compose-Nginx-Php-Laravel-Mysql

2. Entre na pasta Docker-Compose-Nginx-Php-Laravel-Mysql e copie o arquivo env-example para .env.

   cp env-example .env

3. Rode seu container:

   docker-compose up -d

4. Adicione os domínios no arquivo de hosts do windows.

   127.0.0.1 localhost

   127.0.0.1 api.dev

5. Acessar o shell do container:
    
	winpty docker exec -it nginx bash

	winpty docker exec -it php-fpm bash
	
	winpty docker exec -it mysql bash
   
6. Instruções iniciais para rodar o Laravel no localhost:

	Acessar a pasta: cd /var/www/html
	
	Executar comando para criar pasta vendor do laravel: composer install
	
	Executar comando para criar arquivo de variáveis de ambiente do laravel: cp .env.example .env
	
	Executar comando para gerar chaves necessarias para rodar o laravel: php artisan key:generate

7. Instruções iniciais para rodar o Laravel no api.dev:

	Acessar a pasta api.dev: cd /var/www/html/api.dev
	
	Executar comando para criar pasta vendor do laravel: composer install
	
	Executar comando para criar arquivo de variáveis de ambiente do laravel: cp .env.example .env
	
	Executar comando para gerar chaves necessarias para rodar o laravel: php artisan key:generate
	
8. Abra no navegador

   http://localhost

   http://api.dev

9. Acessar o banco de dados dentro do container Mysql

	mysql -u root -p

10. Comandos básicos para utilizar o banco de dados

	show databases;

	CREATE DATABASE teste;
	
	use teste;
	
	show tables;