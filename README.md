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

### Nova Versão

Melhorias no DockerFile
  - Multi-Stage Build
  - -XX:TieredStopAtLevel=1 (that will slow down the JIT later at the expense of the saved startup time).
  - Use the container memory hints for Java 8: -XX:+UnlockExperimentalVMOptions -XX:+UseCGroupMemoryLimitForHeap. With Java 11 this is automatic by default.
  - Use the spring-context-indexer (link to docs). It’s not going to add much for small apps, but every little helps.
  - Fix the location of the Spring Boot config file(s) with spring.config.location (command line argument or System property etc.).
  - Smaller Images(-50%)
Switch off JMX.

