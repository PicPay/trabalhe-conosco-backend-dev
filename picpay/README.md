# Desafio

Para resolver o desafio optei por utilizar CodeIgniter no Back-End para construir minha API.

Como base de dados, optei por importar o arquivo users.csv para o banco de dados MySQL. Utilizei o [bigdump.php](https://www.ozerov.de/bigdump/) para otimizar o processo de importação, pois o arquvio era muito grande.

Tive problemas para importar todos os registro contidos no arquivo **users.csv**. Algumas linhas estavam corrompidas, por isso não foi possível importar tudo.

## Configurações

### Rodando o APP
- Copiar a pasta **picpay** para a raiz do Servidor Web
- Copiar o arquivo **bigdump.php** para a raiz do Servidor Web
- Copiar o arquivo **users.csv** para o mesmo local do bigdump.php
- Rodar o script do banco de dados que encontra-se na raiz do projeto.
- Importar os dados do arquivo **users.csv** utilizando o **bigdump.php** (demora um pouco!!)
- Rodar a aplicação

### Acesso ao APP
**email:** joaopauloangeletisouza@gmail.com

**senha:** 123456

