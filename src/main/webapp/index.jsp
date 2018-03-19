<!DOCTYPE html>
<html lang="br">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KKlein - Projeto Picpay</title>
  
    <link rel="stylesheet" href="contents/css/bootstrap.min.css" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="contents/font-awesome/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="contents/css/animate.min.css" type="text/css">
    <link rel="stylesheet" href="contents/css/creative.css" type="text/css">
    <link rel="stylesheet" href="contents/table/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    
</head>
<body id="page-top">
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">KKlein</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
	                <li>
	                	<a class="navbar-brand page-scroll" href="#page-top">Inicio</a>
	                </li>
                    <li>
                        <a class="page-scroll" href="#about">Pesquisar alguem</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Técnologias utilizadas</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contato</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
        <div class="header-content">
            <div class="header-content-inner">
                <h1>Quem você procura?</h1>
                <hr>
                <p>Esta é uma API REST que busca usuarios pelo nome e username a partir de uma palavra chave em um banco de dados.</p>
                <a href="#about" class="btn btn-primary btn-xl page-scroll">COMEÇAR</a>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">

        <div class="container">
         
            <div class="row">
				<br>              
                <div class="col-lg-12 text-center">
                
                	<h2 class="section-heading">Digite o nome que deseja pesquisar</h2>
                	
                    <hr class="light">
		            <form action="/action_page.php">
                      <div class="form-group">
		            	    <input class="form-control input-lg" id="input_pesquisa" type="text" placeholder="Pesquisar...">
			            </div>
		            </form>
                    <hr class="light">
                    <div id="divLoad"></div>
					<table id="tabela_usuarios" class="table">
					    <thead>
					      <tr>
					        <th style="text-align: center">Nome</th>
					        <th style="text-align: center">Username</th>					        
					        <th style="text-align: center">ID</th>
					      </tr>
					    </thead>
					    <tbody>
					    	
					    </tbody>
					  </table>
					  
					  <div class="row">
					  
					  
						<div class="col-sm-5">
							<div class="dataTables_info" id="tabela_usuarios_info" role="status" aria-live="polite">							
							</div>
						</div>
					
						<div class="paginacao">
						  <button type="button" class="btn btn-primary" onclick="consultar(-1)" id="btn_ant" >Anterior</button>
						  <button type="button" class="btn btn-primary" onclick="consultar(1)" id="btn_prox">Proximo</button>
						</div>

					</div>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Técnologias Utilizadas</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary"></i>
                        <h3>Java</h3>
                        <p class="text-muted">Linguagem utilizada como base do backend do projeto.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <h3>Mysql</h3>
                        <p class="text-muted">Banco de dados utilizado para armazenar dados da aplicação.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary" data-wow-delay=".2s"></i>
                        <h3>Bootstrap</h3>
                        <p class="text-muted">Framework utilizado para estilizar a interface além do template startbootstrap-creative-1.0.2.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary" data-wow-delay=".3s"></i>
                        <h3>Hibernate</h3>
                        <p class="text-muted">Abstrai o código SQL e toda a camada JDBC e o SQL é gerado em tempo de execução. Mais que isso, ele vai gerar o SQL que serve para um determinado banco de dados.</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary"></i>
                        <h3>EJB</h3>
                        <p class="text-muted">Este é o cara que controla a transação, mensagens, segurança do projeto, etc...</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <h3>JQuery</h3>
                        <p class="text-muted">Biblioteca javascript  de código aberto desenvolvida com a finalidade de simplificar os scripts para navegação do documento HTML.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary" data-wow-delay=".2s"></i>
                        <h3>Ajax</h3>
                        <p class="text-muted">AJAX é responsavem por carregar e renderizar uma página, utilizando recursos de scripts rodando pelo lado cliente, buscando e carregando dados em background sem a necessidade de reload da página.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary" data-wow-delay=".3s"></i>
                        <h3>Maven</h3>
                        <p class="text-muted">Este é o cara que faz o controle de dependencias do projeto, gerencia o ciclo de vida do projeto e as etapas para construção do mesmo</p>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <section id="contact">
	    <aside class="bg-dark">
	        <div class="container text-center"> 
	            <div class="call-to-action">
	                <h3>Keoma Klaver Klein</h3>
	            </div>
	        </div>
	    </aside>
	    
        <div class="container"> 
            <div class="row text-center">
            <hr class="primary">
            <p>Carreira desenvolvida na área de aplicações Cliente-Servidor, com experiência em manutenção de sistemas 
                    	voltados para área comercial, utilizando as tecnologias <b>Java</b> e <b>Delphi</b>, banco de dados <b>Oracle</b>, <b>PostgreSQL</b> e <b>MySql</b>.</p>
            <p>Formação acadêmica: <b>Bacharelado em Ciência Da Computação</b> (7º período) na FAESA. </p>
            <p>Nesta instituição pude aproveitar varios cursos de extenção como <b>Desenvolvimento de Aplicativos Móveis utilizando Javascript/AngularJS</b>, 
            <b>Introdução ao Delphi XE5</b> e <b>Desenvolvimento Ágil com Java e SPRING MVC</b>.</p>
            <p>Participação também em 3 dos 4 <b>HackFaesa</b>, evento no surgiram bons projetos como o <b>Politicard</b> (em breve versão beta) 
                    	e o <b>Cambit</b> (Sistema de troca de itens)</p>
                
                
                
                
                <div class="col-lg-2 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x wow bounceIn"></i>
                    <p>+55 27 999232326</p>
                </div>
                <div class="col-lg-2 text-center">
                    <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                    <p><a href="mailto:keoma.klein1@gmail.com">keoma.klein1@gmail.com</a></p>
                </div>
                <div class="col-lg-2 text-center">
                    <i class="fa fa-facebook-official fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                    <p><a href="https://www.facebook.com/keoma.klein">Facebook</a></p>
                </div>
                <div class="col-lg-2 text-center">
                    <i class="fa fa-linkedin fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                    <p><a href="https://www.linkedin.com/in/keoma-klein-30735497/">Linkedin</a></p>
                </div>
            </div>
        </div>
    </section>



    <script src="contents/js/jquery.js"></script>
    <script src="contents/js/bootstrap.min.js"></script>
    <script src="contents/js/jquery.easing.min.js"></script>
    <script src="contents/js/jquery.fittext.js"></script>
    <script src="contents/js/wow.min.js"></script>
    <script src="contents/js/creative.js"></script>

	<script src="contents/table/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="contents/table/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="contents/table/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="http://pagination.js.org/dist/2.1.2/pagination.js"></script>

	<script>
	
	var pagina = 1;
	var pagina_total = 1;
	
	$("#btn_prox").prop("disabled",(pagina_total <= pagina))
	$("#btn_ant").prop("disabled",(pagina <= 1));

	
	$(document).ready(function(){		    	
	    $("#input_pesquisa").on('keyup', function(event){
	    	
			var palavra = $('#input_pesquisa').val();
			//if(palavra.length > 2){
				pagina = 1;
		    	consultar_ajax(palavra);
			//}
	    });
	    
	});

	function consultar(num){
		pagina += num;
		
		$("#btn_ant").prop("disabled",(pagina <= 1));
		
		if(pagina < 1){
			pagina = 1;
			
		}
		var palavra = $('#input_pesquisa').val();
		setTimeout(consultar_ajax(palavra),3000);
	}
	
	function consultar_ajax(palavra){		
		
		var reg_ini = 0;
		var reg_fin = 0;
		$("#divLoad").html("Carregando...");
		$.get('rest/', {palavra:palavra, pagina:pagina}, function (responseText){
	   	   	if(responseText != ''){
	   		   
	   		   table = $('#tabela_usuarios').DataTable();
	   		   table.destroy();
	   		$("#divLoad").html(""); 
	   		   $("#tabela_usuarios tbody tr").remove();
	   		   var qtde_reg = 0; 
		       	 $.each(responseText.employees, function( index, value ) {
		    			   $('#tabela_usuarios').append( '<tr><td>' +value.nome + ' </td> '+
		    					   					 ' <td>' + value.login + ' </td> '+	  		    					   					 
		    					   					 ' <td>' + value.id +' </td> '+
		    					   				 '</tr>' );	 
		    			   qtde_reg = value.qtde_registros;
		    			
		    		   });		       	 
		       	
		       	pagina_total = Math.ceil(qtde_reg/15);
		    	$("#btn_prox").prop("disabled",(pagina_total <= pagina));
		    	
		    	reg_ini = qtde_reg == 0? 0 : ((pagina-1) * 15) + 1;
		       	reg_fin = (qtde_reg > 15 ? ((reg_ini + 14) <= qtde_reg ? reg_ini + 14 : qtde_reg) : qtde_reg);		       	
		       	$("#tabela_usuarios_info p").remove();
		       	$('#tabela_usuarios_info').append("<p>Exibindo " + reg_ini  + " a " + reg_fin  + "  de " + qtde_reg  + " registros</p>");	    	   
	       }		
		})
	}
	  
	 $(function () {
		 $('#tabela_usuarios').DataTable({
		     'paging'      : false,
		     'lengthChange': false,
		     'searching'   : false,
		     'ordering'    : true,
		     'info'        : false,
		     'autoWidth'   : false,
		     'pageLength'  : 15,
		     'retrieve': true
		     
		 });
	 });
	 
	 
	</script>
</body>

</html>