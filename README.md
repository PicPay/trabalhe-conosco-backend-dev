
  # Lumen API + Vue.Js + Docker - Search User

  ![](https://dzwonsemrish7.cloudfront.net/items/0c062c2b400K173M2q1G/Screen%20Recording%202018-09-26%20at%2012.54%20AM.gif?v=47303fe3)

  ## Intro

  - O gif acima foi gravado com a base de 8.000.000 de usários.
  - A peformance foi resolvida apenas utilizando indices.
  - Foi utilizado o Vue Material para o frontend.
  - A aplicação é responsiva.📱
  - A prioridade foi resolvida com uma coluna de `priority` no banco de dados. Que é atualizada por um serviço buscando informações dos textos disponibilizados.

  ## Prerequisites

  Docker instalado.


  ## Installing

  Baixe o projeto

  ```
  Git clone 
  ```

  Vá para pasta do projeto

  ```
  cd trabalhe-conosco-backend-dev
  ```

  Suba os conteiners. (🕰 ± 20 min)

  ```
  docker-compose up -d
  ```

  Execute os comandos para migrar os dados (🕰 ± 30 min)

  ```
  sh cmd.sh
  ```

  ## Frontend

  Acesse a url: http://localhost:5000/#/

  Faça login com os dados:

  ```
  User: picpay@gmail.com
  Password: 12345
  ```

  [Buscando por 'charl' gif](https://dzwonsemrish7.cloudfront.net/items/230C0s0F0U3G1M1J2q15/Screen%20Recording%202018-09-26%20at%2001.00%20AM.gif?v=3ce63476)

  ## Backend

  Documentação completa:
  https://documenter.getpostman.com/view/5151635/RWaRMQVa

  ### POST Login

  Exemplo:
  ```
  http://localhost:8000/auth/login?email=picpay@gmail.com&password=12345
  ```

  Após efetuado o login copie o token para realizar o request na Seach User.

  ### GET Search User

  Exemplo:
  ```
  http://localhost:8000/api/users/?q=Charl
  ```

  Adicione o Token recebido na key `Authorization` no Header do request.



