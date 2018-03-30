<?php
require_once 'controller/ProdutoController.php';
require_once 'model/Produto.php';
$produtoController = new ProdutoController();
$prod = new Produto();

$pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT) : 1;
$tipo = filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_NUMBER_INT) : 0;
$termo = filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING) : "";

if (filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
    $cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
    $prod = $produtoController->pegarUm($cod);
}

$precoExib = "R$ " . str_replace(".", ",", $prod->getPreco());
?>
<div class="panel panel-default">
    <div class="panel panel-heading">
        <strong>Descrição do produto</strong>
    </div>

    <div class="panel panel-body">
        <a href="?pagina=produtos&pag=<?= $pag ?>&tipo=<?= $tipo ?>&termo=<?= $termo ?>" class="btn btn-info">Voltar</a>
        <div id="dvDetalhesProd" class="alignCenter">
            <img src="img/produtos/<?= $prod->getImagem(); ?>" alt="" id="imgDetalhesProd"/>
            <span id="spNomeDetalhesProd"><?= $prod->getNome(); ?></span>
            <span id="spPrecoDetalhesProd"><?= $precoExib ?></span>
            <span id="spDescDetalhesProd"><?= $prod->getDescricao(); ?></span>
        </div>
    </div>
</div>
