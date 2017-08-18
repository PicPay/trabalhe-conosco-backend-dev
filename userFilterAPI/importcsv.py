import csv, sqlite3

con = sqlite3.connect("db.sqlite3")
cur = con.cursor()
#cur.execute("CREATE TABLE User (id vachar(50) not null, nome vachar(50), username vachar(50));") 

ifile = open('users.csv','r') 
read = csv.reader(ifile)
to_db = [(row[0], row[1], row[2], 0) for row in read]

cur.executemany("INSERT INTO user_user (id, nome, username, relevancia) VALUES (?,?,?,?);", to_db)
con.commit()
con.close()