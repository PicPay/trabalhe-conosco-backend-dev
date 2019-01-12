exports.authorize = function(req, res, next) {
  
  if (!req.session.user){
  //console.log(req.session);
  return res.render('login', { title: 'Your session has expired!' });
  }
  else next();
}

exports.register = (req, res) => {
	
	let data = req.body;
	var password = req.body.password;
	var password_conf = req.body.password_conf;
	var email = req.body.email;

	// Checa os campos requeridos
	if(!password || !email) return res.status(400).send({error: "There are missing fields."});
	if (password !== password_conf) return res.status(400).send({error: "Password does not matches"});
	else{
		// Verifica se já existe um usuário com este email
		pool.query('SELECT * FROM public.user WHERE Email=?', [email], (error, results, fields) => {

			if(results>0) return res.status(400).send({error: "Email already in use."});
			
			else{
				bcrypt.hash(req.body.password, 10, function(err, hash) {
					if (err) return res.status(404).send((err));
					else{
						// Store hash in your password DB.
						data = validaData(data);
						data.DataCadastro = new Date().toISOString(); // YYYY-MM-DD

						// Tenta inserir o novo usuário no banco
						pool.query("INSERT INTO public.user (name, email, password) VALUES ($1, $2, $3);", [name, email, hash], (error, results, fields) => {
						if (error) return res.status(500).send({ error });
						else if (!results.rows) return res.status(400).send({error: "Bad request."});
						else 
						return res.render("index", { title: "New User created!" });
						console.log("New session created. User: ", results.rows[0].email);
        				});
					}
				});
			}
		});

    }
}
exports.login = (req, res, next) => {

	var email = req.body.email;
	var password = req.body.password;

    if (req.session.user) return res.send("Login with previous session.");
  
	if (!email ||!password) return res.status(404).send(("Fields can not be empty"));
	
	else{
	  pool.query("SELECT * FROM public.user WHERE email = $1;",[email], (error, results) => {
		if (error){
		console.error(error);
		return res.status(500).send("Internal server error");
		}
	
		if (!results.rows || !results.rows.length) return res.status(404).send(("User can not be found"));
		else{
		//console.log(results.rows[0])
		var hash = bcrypt.hash(password, 10);
		bcrypt.compare(password, results.rows[0].password, function(erre, ress) {
			if(!ress) return res.status(401).send("Auth Failed");
			else{				
			let user = results.rows[0];
            req.session.user = user;
            //console.log("New session created. User: ", results.rows[0].email,"passw:", results.rows[0].password);
            return res.render("index", { title: results.rows[0].name });
			}			
		})
	  }
	 })
	}
}

exports.logout = function(req, res, next) {
	delete req.session.user;
   res.render("logout", { title: 'User disconnected with success'});
  
  }
