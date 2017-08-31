# Desafio PicPay
Sistema desenvolvido para solucionar o desafio.

** Tecnologias utilizadas: ** ApiREST em Nodejs (incluindo jwt e passport para autenticação das rotas), Banco de Dados MySQL, Interface WEB em Apache-PHP, Suporte a Docker

1. ApiREST rodando na porta 3000.
2. Interface WEB rodando na porta 3080.

** Execução: **

1. Clonar o repositório:

git clone https://github.com/gilmarllen/trabalhe-conosco-backend-dev.git

2. Fazer download da base de dados .csv e das listas de prioriedade através do script (Aguardar alguns minutos devido o tamanho do arquivo .csv):

sh download_db.sh

3. Compilar e executar o Docker (Após o "up", agurdar 5 minutos para upload dos dados para o banco MySQL):

sudo docker-compose build

sudo docker-compose up
