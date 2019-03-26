#! /bin/bash

### BEGIN - FUNÇÔES
# Funcao para realizar o import do arquivo csv no banco de dados
mysql_import_csv() {
    echo ">>>> Importing file $1"
    mysql -u root -proot -e "LOAD DATA LOCAL INFILE '/docker-entrypoint-initdb.d/$1' INTO TABLE picpay.users FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '' LINES TERMINATED BY '\r\n' (uuid, nome, username)"
    echo "----- Removing file $1"
    rm -rf $1 
}

# Funcao para atualizar a relevância do registro no banco de dados
# arg1 = int 1 ou 2
# arg2 = uuid
mysql_update_relevancia() {
  echo ">>>>> Updating relevância $1 for uuid '$2'"
  mysql -u root -proot -e "UPDATE picpay.users SET relevancia = $1 WHERE uuid = '$2'"
}

export -f mysql_import_csv
export -f mysql_update_relevancia
### END - FUNÇÔES

echo "###### START - Database seeding proccess"

echo "++++ Create table users"
# Cria tabela necessária para o sistema
mysql -u root -proot -e "source 00-create_database.sql"

echo "++++ Applying some MySQL small improvements"
# Aprimoramento para melhorar o balanceamento entre inserção e busca no banco de dados
mysql -u root -proot -e "SET tx_isolation = 'READ-COMMITTED'"
mysql -u root -proot -e "SET GLOBAL tx_isolation = 'READ-COMMITTED'"
mysql -u root -proot -e "SET SET unique_checks = 0"
mysql -u root -proot -e "SET GLOBAL unique_checks = 0"
mysql -u root -proot -e "SET SET foreign_key_checks = 0"
mysql -u root -proot -e "SET GLOBAL foreign_key_checks = 0"

echo "++++ Deflate source data file (CSV)"
gunzip users.csv.gz

echo "++++ Cleaning source data file (CSV)"
# Retira caracteres scaped para HTML e ASCII
sed -i 's/&amp;/\&/g' users.csv
sed -i "s/&#039;/\'/g" users.csv
sed -i 's/&amp;/\&/g' users.csv

echo "++++ Split the data file"
# recupera o total de linhas do arquivo
total_lines=$(wc -l users.csv | awk '{print $1}')

if [ $total_lines -ge 20000 ]
then
    # divide o arquivo principal em várias partes para com 20.00 linhas cada, para facilitar o processo de importação no banco de dados
    split -l 20000 users.csv user-
    # Coloca 4 execuções paralelas do processo mysql
    ls -rS user-* | parallel --jobs 4 --joblog mysql_import.log mysql_import_csv
fi

echo "++++ Backing MySQL configurations"
mysql -u root -proot -e "SET SET unique_checks = 1"
mysql -u root -proot -e "SET GLOBAL unique_checks = 1"
mysql -u root -proot -e "SET SET foreign_key_checks = 1"
mysql -u root -proot -e "SET GLOBAL foreign_key_checks = 1"

echo "++++ Remove temporary files"
rm -rf user*

echo "###### END - Database seeding proccess"

echo "..."

echo "###### START - Database relevância update"

echo "+++++ Updating from relevancia 1 file"
if [ -f "./lista_relevancia_1.txt" ]
then
	cat lista_relevancia_1.txt | parallel --jobs 10 --joblog mysql_relevancia.log mysql_update_relevancia 1
else
	echo "File 'lista_relevancia_1.txt' not found."
fi
echo "+++++ Process ended"

echo "+++++ Updating from relevancia 2 file"
if [ -f "./lista_relevancia_2.txt" ]
then
	cat lista_relevancia_2.txt | parallel --jobs 10 --joblog mysql_relevancia.log mysql_update_relevancia 2
else
	echo "File 'lista_relevancia_2.txt' not found."
fi
echo "+++++ Process ended"

echo "###### END - Database relevância update"
