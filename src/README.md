# Teste para o Picpay
Este projeto tem o propósito montar uma API REST e um front-end que busque usuários por palavra-chave.

## Dependências
- Docker
- Composer
- PHP 7.2.15
- Apache
- MySQL 5.7
- Slim Framework

##Front-end
http://localhost

##API
http://localhost/api/users?q=apolonio&page=1
http://localhost/api/user/01207a7b-e948-4efb-8412-82a1507decba
###Basic Auth
User: picpay | Pass: picpaypass

## Instalação
```
#Entrar no diretório para iniciar o docker
$ cd src/

#Iniciar os containers no docker
$ docker-compose up --build

#Acessar a aplicação no browser
http://localhost
```