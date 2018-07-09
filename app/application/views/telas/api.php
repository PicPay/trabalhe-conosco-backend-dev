<div class="container">
	<div class="row">

    
        
        <div class="col-md-12">
        


        <div class="card border-primary mb-3">

<div class="card-body">
    

<p>Realize a busca dos usuarios via api, veja um exemplo abaixo:</p>

<pre><code><?= base_url().'api/usuarios/'.ci()->picpay_model->api_code().'?busca=bar&pg=1';?>
</code>
</pre>

<p>Exemplo retorno:</p>
<style>
#retorno {
        border:2px solid #ccc;
        padding:5px;
}
</style>
<pre id="retorno"><code>{
    "prioridade_maxima": [
        {
            "Id": "de7bc1f1-039a-49ca-afda-7a3a5d4bfe02",
            "Nome": "Joseane Baracat",
            "Username": "joseanebaracat",
            "relevancia": "1",
            "Prioridade": "1"
        },
        {
            "Id": "0bea8a99-f178-4cfe-9170-6ee1620a2720",
            "Nome": "Marcela Bariani",
            "Username": "marcela.bariani",
            "relevancia": "1",
            "Prioridade": "1"
        }
    ],
    "prioridade_minima": [
        {
            "Id": "cc214ff7-6e3e-4820-9b73-ca20da69bd94",
            "Nome": "Adonis Barissa",
            "Username": "adonis.barissa",
            "relevancia": "0",
            "Prioridade": "0"
        },
        {
            "Id": "b0db3f6a-c012-45e6-a601-6861adc46f9b",
            "Nome": "Edelzuita Falqueto Barza",
            "Username": "edelzuitafalquetobar",
            "relevancia": "0",
            "Prioridade": "0"
        },
        {
            "Id": "6cc718bc-a3cb-4015-b685-72aa1f2a36fe",
            "Nome": "Franciellen Flor Barronca",
            "Username": "franciellenflorbarro",
            "relevancia": "0",
            "Prioridade": "0"
        },
        {
            "Id": "c3bb8b2d-433d-41b0-a935-83ea4977789c",
            "Nome": "Heloisa Baracat",
            "Username": "heloisa.baracat",
            "relevancia": "0",
            "Prioridade": "0"
        },
        {
            "Id": "c359786d-1f3b-4064-b430-6b6184a59708",
            "Nome": "Saionara Barsante",
            "Username": "saionarabarsante",
            "relevancia": "0",
            "Prioridade": "0"
        },
        {
            "Id": "4a7fd2d3-7bd8-4ae4-880e-3617f8f175b3",
            "Nome": "Salim Barissa",
            "Username": "salimbarissa",
            "relevancia": "0",
            "Prioridade": "0"
        }
    ],
    "outros": [],
    "pagina": "1"
}</code>
</pre>



</div>

        </div>


</div>

</div>

</div>


