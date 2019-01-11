## Descrição

App PicPay - Aplicação desenvolvida em Laravel 5.7(projects/api-service) e Angular 7(projects/picpay-app) por [Júlio Barbosa](https://github.com/JulioBarbosa)


## Requisitos

1. Instaldo Docker [https://www.docker.com/](https://www.docker.com/)
2. Instaldo Docker Compose [https://docs.docker.com/compose/](https://docs.docker.com/compose/)


## Instalação/Configuração

1. Execute o comando ```docker-compose up -d``` no caminho do projeto.

2. Importação do banco de dados: Existe duas maneiras de importa. (Download: https://s3.amazonaws.com/careers-picpay/users.csv.gz) 
* 2.1 - Primeira - criei um Seed que lê o arquivo user.csv e importa no schema criado dentro da tabela users.
  * Extraia o arquivo users.csv para o caminho ```./projects/api-service/database/seeds/imports```
  * Descomente a linha 18 do arquivo ```./projects/api-service/database/seeds/DatabaseSeeder.php``` ficando:
```php
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PreferenceSeeder::class
        ]);
    }
```
  * Execute o comando ```php artisan db:seed```

Observação: Não é aconselhado usar essa operação porque o volume de dados são muitos e a ultima vez que rodei levou 3 dias pra finalizar. O engige InnoDB faz com que os inserts demore bastante.

  * 2.2 - Importar o users.csv para a tabela users nos mesmo campos existentes da tabela. 

Observação: Fiz a importação pelo IDE Datagrip é bem simples, lá mostra quais as colunas mapeada no arquivo será inserido na tabela. 


## Acesso

Acesso: [http://localhost:4200](http://localhost:4200)

Acesso da API é somente para criar usuário, logar, criar um token novo OAuth2.
Acesso API: [http://localhost:8000](http://localhost:8000)


## Finalização

Obrigado!
Qualquer dúvida só enviar e-mail para julio.barbosa.15@gmail.com

 
