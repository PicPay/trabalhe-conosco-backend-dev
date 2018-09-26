#!/bin/sh

docker exec -it search-user composer dump-autoload
docker exec -it search-user php artisan migrate --seed

echo "Migrando 8.000.000 de usuários. Tempo aprox. de ± 30 min"
docker exec -i search-user-db mysql -h "localhost" -u "root" "-proot" "picpay" < "./database/users_from_csv.sql"
docker exec -it search-user curl 'http://localhost:80/api/users/prioritize'
docker exec -i search-user-db mysql -h "localhost" -u "root" "-proot" "picpay" < "./database/update_indexes.sql"
echo "Usuários migrados com sucesso"