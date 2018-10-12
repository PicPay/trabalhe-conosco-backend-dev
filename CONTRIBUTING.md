# Desafio PicPay

## Código

1. No código foi utililizado o SLIM como framework principal.
2. Foi criado uma anotação para o SWAGGER, que gerou a documentação que podemos visualizar em <localhost>/users .
3. Foi também utilizado o reDoc para visualização da documentação da API.

## Banco de dados:
1. O arquivo docker/mysql/initial_file.sql contém a estrutura de banco criada especificamente para este desafio.

## Docker:
Infelizmente meu laptop pessoal não suporta a instalação do Docker for Windows e com isso, não consegui validar o arquivo que criei para o docker, mas criei ele baseado em dockers criados anteriormente por mim.

## Guia

1. Instalar o composer para PHP e executá-lo na raiz do trabalho:
```sh
$ composer install
```

2. Importar o arquivo mysql contido em docker/mysql/initial_file.sql para o banco de dados.

3. Os dados de banco de dados foram inseridos no único ponto de consulta do código: src/Usuarios/Models/Users.php:60

### Obrigado pela oportunidade!

### Giancarlo Bacci