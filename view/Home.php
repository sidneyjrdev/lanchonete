<?php 
require_once "controller/DestaqueController.php";
require_once "model/Destaque.php";

$destaqueController = new DestaqueController();
$destaques = [];

$destaques = $destaqueController ->exibicaoHome();
?>

<div class="panel panel-default">
<div class="panel panel-heading">
    <strong>Home</strong>
</div>

<div class="panel panel-body">
    <div id="dvImgFixa">
            <img src="img/banner-fixo-home.jpg" id="imgFixaHome" alt=""/>
    </div> 
    <span id="spHome">Promoções e destaques</span>
    <div class="row">
    <?php
    $i = 1;
    foreach($destaques as $dest){
        
        ?>
        <div class="dvDestaque col-lg-6 col-md-6">
             <img src="img/destaques/<?= $dest->getImagem(); ?>" class="imgDestHome" alt=""/>
        </div>
    <?php
    if($i % 2 == 0){
        ?>
    </div>
    <div class="row">
    <?php
    }
    }
    ?>
    </div>
</div>
</div>







