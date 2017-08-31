module.exports = (app, con) => {

	var bodyParser = require("body-parser");
	var auth = require("../auth.js")();

	app.use(bodyParser.json());
	app.use(bodyParser.urlencoded({ extended: true }));

	//Limite da quantidade de elementos retornados no JSON por cada pagina 
	const qtd_ele_pag = 15;

	//GET de todos usuarios da DB
  	app.get("/user/", auth.authenticate(), (req,res) => {

		con.query('select * from usuarios LIMIT 0, ?', qtd_ele_pag, (err,rows) => {
		if(err){
		throw err;
		}

		console.log('Requisição Recebida - Todos usuarios\n');
		res.status(200);
		res.setHeader('Content-Type', 'application/json');
		res.json(rows);
    	});

    });

  	//GET dos usuarios da DB por username
  	app.get("/user/username/:username_search", auth.authenticate(), (req,res) => {
	  	var value = req.params.username_search;
	  	console.log(`Busca username = ${value}`);

	  	con.query('select * from usuarios as u where username = ? order by field (id, (select id from relevancia_1 where id = u.id)) desc, field (id, (select id from relevancia_2 where id = u.id)) desc, nome LIMIT 0, ?', [value, qtd_ele_pag], (err,rows) => {
			if(err){
			throw err;
			}

			res.status(200);
			res.setHeader('Content-Type', 'application/json');
			res.json(rows);
    	});

    });

  	//GET dos usuarios da DB por nome
  	app.get("/user/nome/:nome_search", auth.authenticate(), (req,res) => {

	  	res.redirect('/user/nome/' + req.params.nome_search + '/page/1');

    });

  	//GET dos usuarios da DB por nome e pagina
    app.get("/user/nome/:nome_search/page/:num", auth.authenticate(), (req,res) => {
	  	var value = req.params.nome_search;
	  	console.log(`Busca nome = ${value}`);

	  	var pag = req.params.num;

	  	value = '%' + value + '%';
	  	con.query('select * from usuarios as u where nome like ? order by field (id, (select id from relevancia_1 where id = u.id)) desc, field (id, (select id from relevancia_2 where id = u.id)) desc, nome LIMIT ?, ?', [value, (pag-1)*qtd_ele_pag, qtd_ele_pag+1], (err,rows) => {
		if(err){
		throw err;
		}
		
		if(rows.length == (qtd_ele_pag+1))
			var have_next = true;
		else
			var have_next = false;
		
		var json_obj = { 'Usuarios' : rows };
		json_obj['Tem_proximo'] = have_next;
		
		json_obj.Usuarios.splice(qtd_ele_pag, 1);

		res.status(200);
		res.setHeader('Content-Type', 'application/json');

		res.json(json_obj);
    	});

    	

    });

    //GET dos dados do usuario logado na API em uma sessao autenticada pelo jwt/passport
    app.get("/logged", auth.authenticate(), function(req, res) {
	  
	  var ud = req.user.id;
	  
	  con.query('select * from autenticacao where id = ?', ud, (err,rows) => {
	      if(err){
	        throw err;
	      }

	      res.status(200);
	      res.setHeader('Content-Type', 'application/json');

	      delete rows[0].password;
	      var json_obj = { 'usuario' : rows[0] };
	      

	      res.json(json_obj);

	    });
	  
	});

    //POST para registro do usuario que ira utilizar a API
	app.post("/register", function(req, res) {
	    if (req.body.login && req.body.password) {

		    var login = req.body.login;
		    var password = req.body.password;

		    con.query('select * from autenticacao where login = ?', login , (err,rows) => {
		      if(err){
		        throw err;
		      }

		      if(rows.length == 0)
		      {
		      	con.query('insert into autenticacao (login, password) value (?, ?)', [login, password] , (err,rows) => {
			        if(err){
				        throw err;
				      }

			        res.status(200);
			        res.setHeader('Content-Type', 'application/json');
			        res.json({status : true});
			      });
		      }
		      else
		      {
		      	res.status(200);
		        res.setHeader('Content-Type', 'application/json');
		        res.json({status : false});
		      }


		    
	    });

	  } else {
	    res.sendStatus(401);
	  }
  
	});

};