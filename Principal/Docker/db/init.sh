psql -c "create role pic_pay createdb login password '183729';"

psql -c "create database pic_pay with owner = pic_pay encoding = 'utf8' tablespace = pg_default;"

echo "Iniciando restauração do banco de dados."

pg_restore -d pic_pay -F c /app/data/data.dump

echo "Banco de dados restaurado com sucesso.";