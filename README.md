![PicPay](https://imgur.com/a/8ZtZI)

# Solução para Teste Backend PicPay

# Tecnologias utilizadas

ApiREST desenvolvida com o Slim PHP Framework para solucionar o desafio.
Tecnologias utilizadas:
Slim PHP Framework
Composer Dependency Manager
HTML, PHP, CSS e JavaScript
MySQL

# Instalação

1) Copiar a pasta slimapp para sua pasta web (www no Linux ou htdocs no Windows).
2) Importar o banco de dados do arquivo db.sql
3) Adicionar a seguinte linha ao arquivo hosts (/etc/hosts no Linux ou C:\Windows\System32\drivers\etc\hosts no Windows).

127.0.0.1 desafio.picpay

4) Adicionar o host virtual ao arquivo de configuração do Apache. No windows, utilizando XAAMP o arquivo httpd-vhosts fica em C:\xampp\apache\conf\extra

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/slimapp/public"
    ServerName desafio.picpay
</VirtualHost>

# Utilização

1) Abra o navegador e acesse http://desafio.picpay/api/busca
