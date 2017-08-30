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
    <title>API PicPay / Busca Username</title>
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
		<font color="#FFFFFF"><h1>Busca Username</h1></font>
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
            if(isset($_POST['username']))
            {
                $username = strval($_POST['username']);
                echo "Buscar: <input type=\"text\" name=\"username\" placeholder=\"username\" value=\"$username\">";
            } else
            {
                echo "Buscar: <input type=\"text\" name=\"username\" placeholder=\"username\">";
            }
        ?>
        <button type="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"></span>
        </button>
        </form>
    </div>

    </div>
    </div>

    <br>

    <?php
	    if(isset($_POST['username']))
        {
            $json_url = "http://" . "localhost" . ":3000/user/username/" . $_POST['username'];
            $json_url = str_replace(" ", "%20", $json_url);
            
            $opts = array('http' =>
            array(
                'method'  => 'GET',
                'header'  => 'token: ' . $_SESSION["token"]
                )
            );

            $context  = stream_context_create($opts);
            
            $json_str = file_get_contents($json_url, false, $context);

        } else
        {
            $json_str = "[]";
        }

        $usuarios = json_decode($json_str);
    ?>

	<div class="container">
    <div class="row">

    <div class="col-md-12">
    <table class="table table-striped">
	    <tr>
		    <th>ID</th>
		    <th>Nome</th> 
		    <th>Username</th>
	  	</tr>
	  	<?php
	  	foreach ( $usuarios as $us )
	    {
		  	echo"<tr>
			    	<td>$us->id</td>
			    	<td>$us->nome</td>
			    	<td>$us->username</td>
		  		</tr>";
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