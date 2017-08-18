use picpay
db.users.update({},{\$set: {lista1: 0,lista2: 0, tags: []}},{multi:true})
db.users.createIndex( { id: 1, tags: 1 } )
