<?php

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$paginas = [
    "acompanhamento" => "view/AcompanhamentoView.php",
    "bebidas" => "view/BebidasView.php",
    "contato" => "view/ContatoView.php",
    "home" => "view/Home.php",
    "sanduiche" => "view/SanduicheView.php",
    "simulacao" => "view/SimulacaoView.php",
    "sobreNos" => "view/SobreNosView.php",
    "login" => "admin/Login.php",
    "produtos" => "view/ProdutoView.php",
    "detalhesprod" => "view/DetalhesProd.php"
   ];

if ($pagina) {
    $encontrou = false;
    foreach ($paginas as $key => $value) {

        if ($key == $pagina) {
            $encontrou = true;
           
            require_once ($value);
            break;
        }
    }

    if ($encontrou === false) {
        require_once ("view/Home.php");
    }
} else {
    require_once ("view/Home.php");
}
