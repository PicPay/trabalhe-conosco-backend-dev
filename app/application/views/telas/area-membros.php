<style>
.hide {
    display:none;
}
</style>

<div class="container">
	<div class="row">

    
        
        <div class="col-md-12">
        
        <?php echo html_paginacao();?>    



<div class="table-responsive">



<div class="card border-primary mb-3 <?= !ci()->input->get('busca')?'hide':''?>">

<?php if(count($list['prioridade_maxima']) or count($list['prioridade_minima'])){?>

  <div class="card-header">Resultado</div>
  <div class="card-body">


    <?php if(count($list['prioridade_maxima'])):?>
    <h4 class="card-title">Lista de relevância 1</h4>
   
    
    <table id="mytable" class="table table-bordred table-striped">
                   
        <thead>
        
        <th>ID</th>
        <th>Nome</th>
        <th>Username</th>
        
        </thead>
        <tbody>
            <?php foreach($list['prioridade_maxima'] as $item): ?>
                <tr>
                        
                    <td><?php echo $item->Id;?></td>
                    <td><?php echo $item->Nome;?></td>  
                    <td><?php echo $item->Username;?></td>
                    
                </tr>
        
            <?php endforeach; ?>
        
         
        </tbody>
            
    </table>



    <?php endif;?>
    <?php if(count($list['prioridade_minima'])):?>
    <h4 class="card-title">Lista de relevância 2</h4>
   
    
   <table id="mytable" class="table table-bordred table-striped">
                  
       <thead>
       
       <th>ID</th>
       <th>Nome</th>
       <th>Username</th>
       
       </thead>
       <tbody>
            <?php foreach($list['prioridade_minima'] as $item): ?>
                <tr>
                        
                    <td><?php echo $item->Id;?></td>
                    <td><?php echo $item->Nome;?></td>  
                    <td><?php echo $item->Username;?></td>
                    
                </tr>
        
            <?php endforeach; ?>
            
        
        
    </tbody>
           
   </table>

  <?php endif;?>

  </div>
<?php }elseif(ci()->input->get('busca')){ ?>
            
    
    <div class="card-header">Resultado</div>
    <div class="card-body">
        <div class="alert alert-dismissible alert-danger ">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Não foi possivel retornar nenhum resultado com o texto informado!.
        </div>
    </div>

<?php } ?>

</div>


<?php if(count($list['outros'])):?>
<div class="card border-info mb-3">


<?php if(ci()->input->get('busca')){ ?>

    <div class="card-header">Usuários que não estão em nenhuma lista de acordo com a busca</div>
<?php } ?>


  <div class="card-body">
    

    <table id="mytable" class="table table-bordred table-striped">
                   
    <thead>
       
       <th>ID</th>
       <th>Nome</th>
       <th>Username</th>
       
       </thead>
       <tbody>
            <?php foreach($list['outros'] as $item): ?>
                <tr>
                        
                    <td><?php echo $item->Id;?></td>
                    <td><?php echo $item->Nome;?></td>  
                    <td><?php echo $item->Username;?></td>
                    
                </tr>
        
            <?php endforeach; ?>
            
            
            <?php if(!count($list['outros'])){ ?>
                
                <tr>
                    <td colspan="3">
                    <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Nenhum resultado foi encontrado nessa lista!</strong> 
                    </div>
                    </td>
                </tr>

                
            <?php } ?>
        
        </tbody>

    </table>

  </div>
</div>

<?php endif; ?>


<?php if((count($list['prioridade_maxima']) or count($list['prioridade_minima'])) and ci()->input->get('busca')):?>

<div class="card border-warning mb-3">
  <div class="card-body">

    <a href="<?= base_url() ?>" type="button" class="btn btn-info col-md-12"><i class="fa fa-eye"></i> Visualizar lista completa</a>

    </div>
</div>
<?php endif;?>


         

                
            </div>

<?php echo html_paginacao();?>    


        </div>


        
	</div>
</div>


    
    
    