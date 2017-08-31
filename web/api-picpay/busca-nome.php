<!DOCTYPE html>
<html lang="pt">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="icon" type="image/png" href="./images/favicon.png">
    <title>API PicPay / Busca Nome</title>
  </head>
  <body>

    <?php
        session_start();
        if(!isset($_SESSION["token"]))
            header("Location: ./index.php");
    ?>

  	<div class="container">
  	<div class="row">
  	<div class="col-md-2">
      <form action="./logged.php" method="POST">
      <button type="submit" style="padding:0px;">
        <img src="./images/logo_picpay.png" alt="logo" class="img-responsive" width="200px">
      </button>
      </form>
    </div>
    <div class="col-md-10" style="background-color:#32CD32" align="center">
		<font color="#FFFFFF"><h1>Busca Nome</h1></font>
    </div>
    </div>
    </div>

    <br>
    

    <div class="container">
  	<div class="row">

    <div class="col-md-2">
    </div>

    <div class="col-md-10" align="center">
	    <form action="" method="post">
	    <?php
	    	if(isset($_POST['nome']))
	    	{
	    		$nome = strval($_POST['nome']);
	    		echo "Buscar: <input type=\"text\" name=\"nome\" placeholder=\"Nome Sobrenome\" value=\"$nome\">";
    		} else
    		{
    			echo "Buscar: <input type=\"text\" name=\"nome\" placeholder=\"Nome Sobrenome\">";
    		}
	    ?>  	
	  	<input type="hidden" name="page" value="1" />
	  	<button type="submit" class="btn btn-default">
	  		<span class="glyphicon glyphicon-search"></span>
	  	</button>
		</form>
    </div>

    </div>
    </div>

    <br>

    <?php
	
	if(isset($_POST['nome']))
    	{
	$ip_server = $_SERVER['SERVER_NAME'];
		
        $json_url = "http://" . $ip_server . ":3000/user/nome/" . $_POST['nome'] . "/page/" . $_POST['page'];
        $json_url = str_replace(" ", "%20", $json_url);

        $opts = array('http' =>
        array(
            'method'  => 'GET',
            'header'  => 'token: ' . $_SESSION["token"]
            )
        );

        $context  = stream_context_create($opts);
        
        $json_str = file_get_contents($json_url, false, $context);

        $json_obj = json_decode($json_str);

        $pagina_atual = strval($_POST['page']);
        $next_page = strval( intval($_POST['page']) + 1 );
        $previous_page = strval( intval($_POST['page']) - 1 );
        $nome_atual = strval($_POST['nome']);
        

        echo "
        	<div class=\"container\">
        	<div class=\"row\">

  			<div class=\"col-md-2\">
  				<div class=\"row\">

  				<form action=\"\" method=\"post\">		  	
			  	<input type=\"hidden\" name=\"nome\" value=\"$nome_atual\" /> 
			  	<input type=\"hidden\" name=\"page\" value=\"$previous_page\" />
			  	";

			  	if((intval($_POST['page']) - 1) > 0)
			  		echo "<button type=\"submit\" class=\"btn btn-default\">";
			  	else
			  		echo "<button type=\"submit\" class=\"btn btn-default\" disabled>";
			  	echo "			  	
			  		<span class=\"glyphicon glyphicon-arrow-left\"></span>
			  	</button>
				</form>

	        	<form action=\"\" method=\"post\">		  	
			  	<input type=\"hidden\" name=\"nome\" value=\"$nome_atual\" /> 
			  	<input type=\"hidden\" name=\"page\" value=\"$next_page\" />
			  	";

			  	if($json_obj->Tem_proximo == FALSE)
			  		echo "<button type=\"submit\" class=\"btn btn-default\" disabled>";
			  	else
			  		echo "<button type=\"submit\" class=\"btn btn-default\">";
			  	echo "
			  		<span class=\"glyphicon glyphicon-arrow-right\"></span>
			  	</button>
				</form>
				</div>
				
			</div>

			<div class=\"col-md-10\" align=\"center\">
				<h4>Página $pagina_atual</h4>
    		</div>

			</div>
			</div>
        ";

    } else
    {
        $json_str = "[]";
        $json_obj = json_decode($json_str);
    }

    ?>

    <div class="container">
  	<div class="row">

    <div class="col-md-12">
    <table class="table table-striped">
	    <tr>
	    	<th>#</th>
		    <th>ID</th>
		    <th>Nome</th> 
		    <th>Username</th>
	  	</tr>
	  	<?php
	  	$pos = 1;
	  	foreach ( $json_obj->Usuarios as $us )
	    {
		  	echo"<tr>
		  			<td>$pos</td>
			    	<td>$us->id</td>
			    	<td>$us->nome</td>
			    	<td>$us->username</td>
		  		</tr>";
		  	$pos = $pos + 1;
	  	}
	  	?>
	</table>
	</div>

	</div>
	</div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </body>
</html>
