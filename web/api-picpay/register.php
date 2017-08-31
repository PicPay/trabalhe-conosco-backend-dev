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
    <title>API PicPay / Registro</title>
  </head>
  <body>

    <?php

    if(isset($_POST['login']) && isset($_POST['senha']))
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
      $json_url = "http://" . $ip_server . ":3000/register/";
      
      $json_str = file_get_contents($json_url, false, $context);
      
      if($json_str == FALSE)
        $register_status = "Location: ./register.php?status=erro1";
      else
      {
        $json_obj = json_decode($json_str);

        if($json_obj->status == FALSE)
          $register_status = "Location: ./register.php?status=erro2";
        else
          $register_status = "Location: ./index.php?status=register_sucess";
      }

      header($register_status);
    }    

    ?>

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
    if(isset($_GET['status']) && $_GET['status']=="erro1")
    {
      echo "<div class=\"container\">
            <div class=\"row\">


            <div class=\"col-md-12\">
            <div class=\"alert alert-danger\">
              <strong>Erro ao registrar usuario!</strong>
            </div>
            </div>

            </div>
            </div>";
    }

    if(isset($_GET['status']) && $_GET['status']=="erro2")
    {
      echo "<div class=\"container\">
            <div class=\"row\">


            <div class=\"col-md-12\">
            <div class=\"alert alert-danger\">
              <strong>Login já existe!</strong>
            </div>
            </div>

            </div>
            </div>";
    }
    ?>

    <div class="container">

    <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4" align="Center">
      <h4>Registro:</h4>
    </div>
    </div>

    <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
    <form action="" method="post">

    <div class="form-group">
      <label>Login:</label>
      <input type="text" name="login" placeholder="Login" class="form-control" required="">
    </div>

    <div class="form-group">
      <label>Senha:</label>
      <input type="password" name="senha" placeholder="Digite sua senha" class="form-control" required="">
    </div>

    <button type="submit" class="btn btn-default">Criar</button>

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
