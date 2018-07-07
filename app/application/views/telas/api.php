<div class="container">
	<div class="row">

    
        
        <div class="col-md-12">
        


        <div class="card border-primary mb-3">

<div class="card-body">
    

<p>Realize a busca dos usuarios viar api, veja um exemplo abaixo:</p>

<pre><code><?= base_url().'api/usuarios/'.ci()->picpay_model->api_code().'?busca=a&pg=1';?>
</code>
</pre>

<p>Após o terminal do mysql abrir execute o comando:</p>
<style>
#retorno {
        border:2px solid #ccc;
        padding:5px;
}
</style>
<pre id="retorno"><code>{
    "prioridade_maxima": [
        {
            "Id": "fba0be35-7111-43c5-8111-b326360da4d0",
            "Nome": "Rosaria Galhardo",
            "Username": "rosariagalhardo",
            "_id": "1",
            "Prioridade": 1
        },
        {
            "Id": "7354ff5e-cc72-4cc7-a8d0-279f3349c52b",
            "Nome": "Celia Bourguignon Peruna",
            "Username": "celiabourguignonperu",
            "_id": "2",
            "Prioridade": 1
        },
        {
            "Id": "4096545a-3d93-476d-9a25-ae486a12a720",
            "Nome": "Thomas Tessitore",
            "Username": "thomastessitore",
            "_id": "3",
            "Prioridade": 1
        },
        {
            "Id": "18e6d866-8d33-45f2-a896-c759394364c1",
            "Nome": "Dayana Mikaelly",
            "Username": "dayana.mikaelly",
            "_id": "4",
            "Prioridade": 1
        }
    ],
    "prioridade_minima": [
        {
            "Id": "c7ce0869-dd26-49d7-80c1-f634f10d8f5b",
            "Nome": "Ananda Merici",
            "Username": "ananda.merici",
            "_id": "1",
            "Prioridade": 0
        },
        {
            "Id": "81409000-2d02-4209-9da8-ce750ae8cf94",
            "Nome": "Mileny Ugiette Angelinbba",
            "Username": "mileny.ugiette.angel",
            "_id": "2",
            "Prioridade": 0
        },
        {
            "Id": "8199113c-a0ef-427b-b4a3-65f1be413c3f",
            "Nome": "Safira Dudabb",
            "Username": "safiraduda",
            "_id": "3",
            "Prioridade": 0
        }
    ],
    "outros": [
        {
            "Id": "b920916a-a78e-4160-bb5d-c312b590403e",
            "Nome": "Suzy Leonr",
            "Username": "suzyleonr",
            "_id": "18"
        },
        {
            "Id": "eeb7d602-ac2a-4182-b0cf-9108b73ecf2e",
            "Nome": "George Henrque",
            "Username": "george.henrque",
            "_id": "25"
        },
        {
            "Id": "54c6a470-c175-4e3d-89a3-45437e8e1451",
            "Nome": "Ketlin Dimitri Lyzis",
            "Username": "ketlin.dimitri.lyzis",
            "_id": "29"
        }
    ],
    "pagina": "1"
}</code>
</pre>



</div>

        </div>


</div>

</div>

</div>


