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

  	<div class="container">
  	<div class="row">
  	<div class="col-md-2">  	
    	<form action="./index.php" method="POST">
      <button type="submit" style="padding:0px;">
        <img src="./images/logo_picpay.png" alt="logo" class="img-responsive" width="200px">
      </button>
      </form>
    </div>
    <div class="col-md-10" style="background-color:#32CD32">  	
    	
    </div>
    </div>
    </div>

    <br>

    <?php
      if(isset($_GET['status']) && $_GET['status']=="erro")
      {
        echo "<div class=\"container\">
              <div class=\"row\">


              <div class=\"col-md-12\">
              <div class=\"alert alert-danger\">
                <strong>Usuario ou senha incorreto(s)!</strong>
              </div>
              </div>

              </div>
              </div>";
      }

      if(isset($_GET['status']) && $_GET['status']=="register_sucess")
      {
        echo "<div class=\"container\">
              <div class=\"row\">


              <div class=\"col-md-12\">
              <div class=\"alert alert-success\">
                <strong>Login e senha registrados com sucesso!</strong>
              </div>
              </div>

              </div>
              </div>";
      }
    ?>

    <div class="container">
    <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
    <form action="./logged.php" method="post">

    <div class="form-group">
      <label>Login:</label>
      <input type="text" name="login" placeholder="Login" class="form-control" required="">
    </div>

    <div class="form-group">
      <label>Senha:</label>
      <input type="password" name="senha" placeholder="Digite sua senha" class="form-control" required="">
    </div>

    <input type="hidden" name="logar" value="">
    <button type="submit" class="btn btn-default">Entrar</button>

    </form>

    </div>
    </div>

    <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4" align="center">
      <a href="./register.php">Criar conta</a>
    </div>
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