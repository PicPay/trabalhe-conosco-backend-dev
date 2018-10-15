## Picpay test

  
### Solution:  
* I used Redis to make cache of searching engine, after the first load the data on the screen they are cached.  
* In database have index on users_picpay to make this more fast.  
* there were some wrong records with the lastname "souza", a script `(picpay_test/app/Misc/FixWrongName.php)` was created to fix this.  
* I load the data in the database through the seed `(database/seeds/UsersPicpayTableSeeder.php)`, it also sets the user's relevance.  
   
#### Setup:  
Obs: To run this project you must have docker (and docker-compose) and git installed in you environment   
  
#### Clone this project:  
  
`$ git clone git@github.com:murillosampaioleite/trabalhe-conosco-backend-dev.git`  
  
#### Go to project folder...  
  
Run the install.sh and take a coffee...  
  
`$ bash install.sh`  
  
Go to http://localhost and make you registration and enjoy!  
  
#### To turn off the containers:  
  
`$ cd laradock && docker-compose down`  
  
#### To turn on the containers:  
  
`$ cd laradock && docker-compose up -d nginx mysql phpmyadmin workspace redis`  
  
  
#### phpMyAdmin:  
  
To access phpMyAdmin go to http://localhost:8080 , the project database is "default"  
  
`Server: mysql`  
  
`Username: default`  
  
`Password: secret`  
  
### Check the PSR-2:  
  
`docker exec -it laradock_workspace_1 vendor/bin/phpcs --standard=PSR2 /var/www/app -v`
