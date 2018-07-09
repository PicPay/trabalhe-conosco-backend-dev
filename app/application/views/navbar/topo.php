<?php 

if(ci()->login_ok){
    ?>

<form class="form-inline my-2 my-lg-0 pull-left" action="<?= base_url(); ?>">
    <input class="form-control mr-sm-2" type="text" placeholder="Nome ou Usuário" name="busca">
    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
</form>


<ul class="navbar-nav ml-auto">

    <li class="nav-item mx-0 mx-lg-1">
        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="api">Api</a>
    </li>
    <li class="nav-item mx-0 mx-lg-1">
        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="<?= base_url();?>">Home</a>
    </li>
    <li class="nav-item mx-0 mx-lg-1">
        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="logout">Sair</a>
    </li>
</ul>

<?php
}else{

?>


<?php
}
?>