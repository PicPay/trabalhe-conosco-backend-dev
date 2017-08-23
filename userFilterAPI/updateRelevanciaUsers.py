import csv, sqlite3

con = sqlite3.connect("db.sqlite3")
cur = con.cursor()

file = open("lista_relevancia_1.text", "r") 
ids = "("
for line in file: 
	ids = ids + line +","

cur.execute("UPDATE TABLE USER SET RELEVANCIA = 1 WHERE ID IN "+IDS[:-1]+")") 
file.close()

file = open("lista_relevancia_2.text", "r") 
ids = "("
for line in file: 
	ids = ids + line +","
cur.execute("UPDATE TABLE USER SET RELEVANCIA = 2 WHERE ID IN "+IDS[:-1]+")") 
file.close()

con.commit()
con.close()

