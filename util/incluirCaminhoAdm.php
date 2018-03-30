<?php

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$paginas = array(
    "destaques" => "../admin/view/DestaqueAdm.php",
    "logout" => "../admin/Logout.php",
    "perfil" => "../admin/view/PerfilAdm.php",
    "produtos" => "../admin/view/ProdutoAdm.php",
    "homeAdm" => "../admin/view/homeAdm.php",
    "cadastrarAdm" => "../admin/view/CadastrarAdm.php",
    "produtosEdicao" => "../admin/view/ProdutoEdicao.php",
    "mudarSenha" => "../admin/view/MudarSenha.php"
);

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
        require_once ("../admin/view/homeAdm.php");
    }
} else {
    require_once ("../admin/view/homeAdm.php");
}
