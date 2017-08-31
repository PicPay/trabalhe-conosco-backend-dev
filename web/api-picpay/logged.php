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
    <title>API PicPay</title>
  </head>
  <body>

  <?php
    session_start();

    if(!isset($_SESSION["token"]))
    {
      $postdata = http_build_query(
        array(
            'login' => $_POST['login'] ,
            'password' => md5($_POST['senha'])
        )
      );

      $opts = array('http' =>
          array(
              'method'  => 'POST',
              'header'  => 'Content-type: application/x-www-form-urlencoded',
              'content' => $postdata
          )
      );

      $context  = stream_context_create($opts);

      $ip_server = $_SERVER['SERVER_NAME'];
      $json_url = "http://" . $ip_server . ":3000/token/";
      
      $json_str = file_get_contents($json_url, false, $context);
      
      if($json_str == false)
      {
        header("Location: ./index.php?status=erro");
      }

      $json_obj = json_decode($json_str);
      $_SESSION["token"] = $json_obj->token;
    }

    /*-----------------------------------------------------------------*/

    $opts = array('http' =>
        array(
            'method'  => 'GET',
            'header'  => 'token: ' . $_SESSION["token"]
        )
    );

    $context  = stream_context_create($opts);

    $ip_server = $_SERVER['SERVER_NAME'];
    $json_url = "http://" . $ip_server . ":3000/logged/";
    
    $json_str = file_get_contents($json_url, false, $context);

    $json_obj = json_decode($json_str);
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
    <div class="col-md-10" style="background-color:#32CD32">  	
    	<font color="#FFFFFF"> <h4 align="Right"> Bem vindo, <strong> <?php echo $json_obj->usuario->login; ?> </strong> </h4> </font>
      <a href="./logout.php"><h4 align="Right"><strong>SAIR</strong></h4></a>
    </div>
    </div>
    </div>

    <br>

  <div class="container">
  <div class="row">

  <div class="col-md-4"></div>

  <div class="col-md-2">
		<form action="./busca-nome.php" method="POST">
			<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-search"></span> Busca por Nome </button>
		</form>
  </div>

  <div class="col-md-2">
    <form action="./busca-username.php" method="POST">
      <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-search"></span> Busca por Username </button>
    </form>
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
