![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Teste Backend
A API foi feita em Node.js utilizando Express.js, Front End em Vue.js e mongoDB.

# Banco de Dados (Mongo DB)

Foi utilizado o MongoDB para garantir uma busca eficiente dos dados.
O processo de importação dos dados foi pelo comando:

    mongoimport --db test --collection --users --type csv id,name,username --file test.csv 



# API Express
Para iniciar a API basta 'npm install && npm start'. 
    a porta configurada é a 3000

# Front End

Para o Front, basta: 'npm install && npm run serve'
    
Faça seu login, e busque os usuários!!
