<div class="container">
	<div class="row">

    
        
        <div class="col-md-12">
        


        <div class="card border-primary mb-3">

<div class="card-body">
    

<?php if(!file_exists(FCPATH.'db/users.csv')){?>
<div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button>
    <p>
    Algo inesperado aconteceu, o download do banco de dados dos usuários não foi realizando durante o processo
    de instalaçao você pode fazer manualmente.
    </p>

    <p>Adicione o arquivo <b>users.csv</b> dentro da pasta <b>db</b>.</p>
</div>
<?php }else{?>



<p>No terminal execute o comando</p>

<pre><code>docker exec -it testpicpay_robsong /opt/lampp/bin/mysql -uroot picpay
</code>
</pre>

<p>Após o terminal do mysql abrir execute o comando:</p>

<pre><code>LOAD DATA INFILE "<?= FCPATH;?>db/users.csv"
INTO TABLE usuarios
COLUMNS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 0 LINES;
</code>
</pre>


<?php }?>


</div>

        </div>


</div>

</div>

</div>


