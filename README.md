# teste-API-PicPay
API REST criada para o teste Backend da empresa PicPay.

**Autor:** Gilmarllen Pereira Miotto

**Email:** gilmarllen@gmail.com

**Pré-requisitos:** Apache, PHP, MySQL, Nodejs, npm

# Instalação
1. Upar dados para a database MySQL:

    (Download do arquivo users.csv e listas de prioridade. Usuario: root e Senha: picpay123 setados na linha 14, mudar conforme a configuração do MySQL)

    sh init_db.sh

2. Rodar Webservice Nodejs na porta 3000:

    (Modificar configurações MySQL no arquivo config.js de acordo com o ambiente)

    npm install

    node index.js > output.log &

3. Rodar Interface Web PHP na porta 80:

    sudo chmod 777 /var/www/html/

    cp -r web/* /var/www/html/

    Para Acessar: http://localhost/api-picpay/
