<?php
session_start();



use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;
$app->get('/api/busca', function(Request $request, Response $response){

  echo "<html>";
  echo "<head>";
echo"  <style>
#customers {
    font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f4f7f8;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
.form-style{
  max-width: 500px;
  padding: 10px 20px;
  background: #f4f7f8;
  margin: 10px auto;
  padding: 20px;
  background: #f4f7f8;
  border-radius: 8px;
  visibility: hidden;
  font-family: Georgia, \"Times New Roman\", Times, serif;
}
.form-style fieldset{
    border: none;
}
.form-style legend {
    font-size: 1.4em;
    margin-bottom: 10px;
}
.form-style label {
    display: block;
    margin-bottom: 8px;
}
.form-style input[type=\"text\"]{
  font-family: Georgia, \"Times New Roman\", Times, serif;
   background: rgba(255,255,255,.1);
   border: none;
   border-radius: 4px;
   font-size: 16px;
   margin: 0;
   outline: 0;
   padding: 7px;
   width: 100%;
   box-sizing: border-box;
   -webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
   background-color: #e8eeef;
   color:#000000;
   -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
   box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
   margin-bottom: 30px;
}
.form-style input[type=\"submit\"],
.form-style input[type=\"button\"]
{
    position: relative;
    display: block;
    padding: 19px 39px 18px 39px;
    color: #FFF;
    margin: 0 auto;
    background: #21c25e;
    font-size: 18px;
    text-align: center;
    font-style: normal;
    width: 100%;
    border: 1px solid #16a085;
    border-width: 1px 1px 3px;
    margin-bottom: 10px;
}
.form-style input[type=\"submit\"]:hover,
.form-style input[type=\"button\"]:hover
{
    background: #21c25e;
}
html, body {margin: 0; padding: 0;}

#header {
    background: #eee;
    height: 170px;
    font: 12px arial, sans-serif;
}

#header h1 {
    width: 287px;
    height: 140px;
      background: url(https://mueros.net/upload/imagens/00fb6afc8b.png) no-repeat 0 0;
}

#header button {
    margin-top:30px;
    height: 30px;
    background: #21c25e;
    color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.button2 {
    height: 25px;
    background: #21c25e;
    color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
}
  </style>";

  if($_SESSION['logged_in'] == 1)
  {
  echo "<div id=\"header\">
    <h1></h1>
      <a class=\"button\" href=\"http://desafio.picpay/logoff.php\" target=\"_self\"><button type=\"button\">Logoff</button></a>
      <a class=\"button\" href=\"http://desafio.picpay/register.php\" target=\"_self\"><button type=\"button\">Novo Usuario</button></a>
  </div><br><br>";
}
else
{
  echo "<div id=\"header\">
    <h1></h1>
        <a class=\"button\" href=\"http://desafio.picpay/login.php\" target=\"_self\"><button type=\"button\">Login</button></a>
      <a class=\"button\" href=\"http://desafio.picpay/register.php\" target=\"_self\"><button type=\"button\">Novo Usuario</button></a>
  </div><br><br>";
}

  echo "<div class=\"form-style\">
<form>
<fieldset>
<legend><span></span> Busque por uma palavra chave</legend>
<input type=\"text\" name=\"keyword\" placeholder=\"Digite uma palavra chave...\">
</fieldset>
<input type=\"submit\" value=\"Buscar\" />
</form>
</div>";


if($_SESSION['logged_in'] == 1)
{
echo "<script>
  var x = document.getElementsByClassName(\"form-style\");
  x[0].style.visibility = \"visible\";
</script>";
}
else
{
echo "<script>
  var x = document.getElementsByClassName(\"form-style\");
  x[0].style.visibility = \"hidden\";
</script>";
}

  if (!empty($_GET["keyword"]))
  {

    if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
      $startrow = 0;
    } else {
      $startrow = (int)$_GET['startrow'];
    }

  //  echo $startrow;
    //echo $_GET['startrow'];
    $prev = $startrow-15;

    $sql = "SELECT * FROM usuarios AS u WHERE name LIKE '" . '%' . $_GET['keyword'] . '%' . "'  ORDER BY field (id, (SELECT id FROM lista1 WHERE id = u.id)) DESC, field (id, (SELECT id FROM lista2 WHERE id = u.id)) DESC, name LIMIT $startrow, 15";
    ini_set('max_execution_time', 300);
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
  //  print_r($customers);


    $table = "<table id=\"customers\">\n";

       // The header
       $table .= "\t<tr>";
       // Take the keys from the first row as the headings
      // foreach (array_keys($customers) as $heading) {
           $table .= '<th>' . 'ID' . '</th>';
           $table .= '<th>' . 'Name' . '</th>';
           $table .= '<th>' . 'Username' . '</th>';
    //   }
       $table .= "</tr>\n";

       // The body
       foreach ($customers as $row) {
           $table .= "\t<tr>" ;
           foreach ($row as $cell) {
               $table .= '<td>';

               // Cast objects
               if (is_object($cell)) { $cell = (array) $cell; }


                   $table .= (strlen($cell) > 0) ?
                       htmlspecialchars((string) $cell) :
                       $null;


               $table .= '</td>';
           }

           $table .= "</tr>\n";
       }

       $table .= '</table>';
       echo $table;

       $string = "busca";
       $string .= "?keyword=";
       $string .= $_GET['keyword'];
       $string .= "&startrow=";
       $string .= $startrow+15;

       $string2 = "busca";
       $string2 .= "?keyword=";
       $string2 .= $_GET['keyword'];
       $string2 .= "&startrow=";
       $string2 .= $prev;

       if ($prev >= 0)
       {
        echo "<a class=\"button2\" href=$string2>Anterior</a><div>";
        }
       echo "</div><a class=\"button2\" href=$string>Proxima</a>";

     }
});


?>
