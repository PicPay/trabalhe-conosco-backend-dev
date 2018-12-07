![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

### Dependências

- Java 8
- Maven 3
- Docker
- Docker-Compose


### Passos Para Execução

- Clonar ou baixar o [projeto](https://github.com/brenopessoa/trabalhe-conosco-backend-dev.git)
- Acessar a pasta raiz do projeto trabalhe-conosco-backend-dev/picpay.
- Tornar o arquivo buildAndRun.sh executável( chmod +x buildAndRun.sh ) , ou executar os comandos deste arquivo no terminal.
- Acessar localhost:8080/.

### Autenticação

```
user : picpay
password : p1cp@y
```

### Serviço

```
http://localhost:8080/resources/usuarios?id={id}&nome={nome}&username={username}&page={pagina}
```
- Todos os parâmetros são opcionais.
- O serviço responde nos formatos de dados xml (Content-Type=application/xml)  e json (Content-Type=application/json) .

### Testes

Caso deseje rodar os testes da aplicação executar os seguintes passos:

- Acessar o arquivo application.properties localizado em picpay/src/main/resources.
- Alterar o valor da propriedade spring.profiles.active para dev(spring.profiles.active="dev").
- Executar os testes.
