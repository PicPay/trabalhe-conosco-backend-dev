const fs = require('fs');
var util = require('util')
const CircularJSON = require('circular-json');

const MongoClient = require('mongodb').MongoClient;
let url = `mongodb://127.0.0.1:27017`;
let usr =  {useNewUrlParser: true};


const priority = [];

function setPriority(file, data) {
        fs.readFile(file, 'utf8', (err, res) => {
            if(err){
                console.log(err);
            }
            data(res);
        });
}

setPriority(__dirname+'/lista_relevancia_1.txt', (data) => {
    priority.push(data.split(/\r?\n/));
    setPriority(__dirname+'/lista_relevancia_2.txt', (data) => {
        priority.push(data.split(/\r?\n/));
    });
});

exports.getUsers = (req, res) => {
    let keys = Object.keys(req.body);
    let key_word = keys.toString()
    let page = req.params.page;
    let p = page - 1;
    let skip = p*15;
    console.log(p*15)


    const regex = new RegExp(key_word);
    MongoClient.connect(url, usr, (err, client) => {
            let db = client.db('picpay');
            let col = 'users';
            let query = { $or: [{ "name": { $regex: regex, $options: 'i' } }, { "username": { $regex: regex, $options: 'i' } }]};
            if(err) throw err;
            console.log("Connected");
            db.collection(col).find(query).skip(skip).limit(15).toArray(function(error, documents) {
                    if (err) throw error;
                    documents.sort((a, b) => {
                            let id_a = a.id;
                            let id_b = b.id;
                            if (priority[0].indexOf(id_a) !== -1)
                                return 1;
                            if (priority[0].indexOf(id_b) !== -1)
                                return -1;
                            if (priority[1].indexOf(id_a) !== -1)
                                return 1;
                            if (priority[1].indexOf(id_b) !== -1)
                                return -1;
                            else
                                return 0;
                    })
                    res.send(documents).status(200);
            })
                    
    })
};


exports.Login = (req, res) => {
    let json = (req.body)

    MongoClient.connect(url, usr, (err, client) => {
        let db = client.db('picpay');
        let col = 'login';
        let query = json;
        if (err) {
                console.log(err)
        }        
        console.log("Connected");
        db.collection(col).find(query).toArray((error, documents) => {
                if (err) {
                    console.log(err)
                }
                res.send(documents).status(200);
        })
    })
};


exports.Register = (req, res) => {
    let json = Object(req.body)
    let user = json.username
    console.log(json.username)

    MongoClient.connect(url, usr, (err, client) => {
        let db = client.db('picpay');
        let col = 'login';
        let query1 = {username: user};
        if (err) {
                console.log(err)
        }        
        console.log("Register");
        db.collection(col).find(query1).toArray((error, documents) => {
            if (err) {
                console.log(err)
            }
            if(documents.length > 0){
                console.log(documents);
                res.status(204).send("Esse usuário já existe");   
            }else{
                db.collection(col).insertOne(json, function(error, response){
                    console.log('Registrado')
                    if(err){
                        console.log(error)
                    } 
                    res.send(response.ops).status(200);
                })
            }
        })
    })
}