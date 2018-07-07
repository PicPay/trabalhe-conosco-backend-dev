
    <div class="container">    

    
    
       
    </div>
    

<div class="row col-md-12 ">


  <div class="col-lg-4">
    

  </div>

  <div class="col-md-4">


<div id="loginbox" style="margin-top:50px;" class="mainbox">                    
            <div class="panel panel-info" >
            
            <?php if(isset($msg['error'])){?>
                <div class="alert alert-danger"><?=$msg['message']; ?></div>
            <?php }?>
                    <div class="panel-heading">
                        <div class="panel-title">Logar</div>
                        
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" method="POST">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input  name="username"  id="login-username" type="text" class="form-control" name="username" value="" placeholder="usuário">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input name="password" id="login-password" type="password" class="form-control" name="password" placeholder="Senha">
                                    </div>
                                    

                                
                         

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                      <button id="btn-login" href="#" class="btn btn-success">Login  </button>

                                    </div>
                                </div>


                                 
                            </form>     



                        </div>                     
                    </div>  
        </div>


    </div>

  <div class="col-lg-3">
    

    </div>

</div>

