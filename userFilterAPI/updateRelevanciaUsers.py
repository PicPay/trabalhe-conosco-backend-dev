import csv, sqlite3

con = sqlite3.connect("db.sqlite3")
cur = con.cursor()

file = open("lista_relevancia_1.txt", "r") 
ids = "("
for line in file:
	ids = ids + "'%s'," % line[:-1]
sqlupdate = "UPDATE user_user SET RELEVANCIA = 2 WHERE ID IN  %s)" % ids[:-1] 
cur.execute(sqlupdate) 
file.close()

file = open("lista_relevancia_2.txt", "r") 
ids = "("
for line in file: 
	ids = ids + "'%s'," % line[:-1]
sqlupdate = "UPDATE user_user SET RELEVANCIA = 2 WHERE ID IN  %s)" % ids[:-1] 
cur.execute(sqlupdate) 
file.close()

con.commit()
con.close()

