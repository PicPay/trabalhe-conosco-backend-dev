# Sobre o DesafioPicPay

Este software foi desenvolvido para a participação no desafio PicPay e segue as exigências descritas no README do diretório
 anterior.
 

###Requisitos:

docker

docker-compose

php composer

###Tecnologias utilizadas:

PHP 7.2, Laravel 5.7, phpunit, docker, git flow, AWS, apidoc, mysql

###Como rodar o projeto

1 - Entre na pastadesafioPicPay (esta pasta) e execute o composer install

2 - Entre na pasta docker e execute o comando docker-composer up -d

3 - Aguarde alguns minutos para o mysql fazer a importação dos dados necessário

Por padrão para agilizar o processo, eu estou disponibilizando o banco de dados online, pois o download e população do mesmo
demora cerca de 3h em meu computador.

Obs.: Caso prefira usar o banco local, abra o arquivo docker/docker-composer.yml e descomente as linhas abaixo de mysql, depois 
edite o arquivo .env (para agilizar o processo eu o disponibilizei para vocês) e comente os dados do banco online e descomente 
os dados do banco local (mysql).


As observações abaixo são apenas para utilização do banco localmente.

Obs1.: Uma das funções do comando docker-composer up é verificar a existência 
 do arquivo desafio_pic_pay.sql dentro da pasta docker/files, caso o mesmo não exista, será
 executado um comando wget dentro do container para baixar o arquivo que esta disponível [aqui](https://storage.googleapis.com/evecimar/desafio_pic_pay.sql.tar.gz).
 Caso queira, você pode baixar o mesmo, descompacta-lo e colocar o arquivo desafio_pic_pay.sql
 na pasta docker/files, evitanto assim que o container faça o download.
 
Obs2.: A primeira vez que executar o docker-composer up com o mysql decomentado, ira demorar um pouco, pois o sistema
irá baixar o arquivo dump e restaurar o dump no container mysql, que levará aproximadamente 3h. Recomendo ir tomar um café ;)
 

###Utilizando o admin

1 - Acesso o admin pela url http://localhost:8000

2 - Utilize a credenciais: login: evecima.silva senha: qwe123

###Utilizando a API

A documentação da api estará disponível em https://localhost:8000/apidoc/index.html
