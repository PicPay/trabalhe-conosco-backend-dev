FROM mongo

COPY users.csv /users.csv
CMD mongoimport --host mongodb --db picpay --collection users --type csv --file /users.csv --fields "id,name,username"