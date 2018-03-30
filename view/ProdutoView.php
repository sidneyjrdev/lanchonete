<?php
require_once("controller/ProdutoController.php");
require_once("model/Produto.php");
require_once("util/Modif_Datas_e_Precos.php");

$modif = new Modif_Datas_e_Precos();
$produtoController = new ProdutoController();
$mensagem = "";


//paginação - back

$pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT) : 1;
$tipo = filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, "tipo", FILTER_SANITIZE_NUMBER_INT) : 0;
$termo = filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, "termo", FILTER_SANITIZE_STRING) : "";

$qtdTotalProdutos = $produtoController->pegarQtdTotal($tipo, $termo);

$prev = true;
$blocos = ceil($qtdTotalProdutos / 6);

if ($pag != $blocos || ($qtdTotalProdutos % 6 == 0)) {
    $qtdExibida = 6;
} else {
    $qtdExibida = $qtdTotalProdutos % 6;
}
$offset = ($pag * 6) - 6;

$listaPaginacao = [];
$listaPaginacao = $produtoController->pegarFiltro($tipo, "nome", $offset, $qtdExibida, $termo);

if ($qtdTotalProdutos == 0) {
    $mensagem = "<div role=\"alert\" class=\"alert alert-danger\">Não há produtos a serem exibidos.</div>";
}
?>

<div class="panel panel-default">
    <div class="panel panel-heading">
        <strong>Produtos</strong>
    </div>


    <!-- Mostrar -->
    <div class="panel panel-body">

        <select name="slTipo" id="slTipo">
            <option <?= ($tipo == 0) ? "selected" : "" ?> value="0">Todos</option>
            <option <?= ($tipo == 1) ? "selected" : "" ?> value="1">Sanduíches</option>
            <option <?= ($tipo == 2) ? "selected" : "" ?> value="2">Acompanhamentos</option>
            <option <?= ($tipo == 3) ? "selected" : "" ?> value="3">Bebidas</option>
            <option <?= ($tipo == 4) ? "selected" : "" ?> value="4">Ingredientes</option>
        </select>
     
        <input type="text" id="txtBusca" name="txtBusca" value="<?= $termo ?>"  placeholder="Digite sua busca(opcional)."/>
        <button class="btn btn-success" id="btnBusca" name="btnBusca">Buscar</button>  

    </div>


    <div class="mensagem"><?= $mensagem; ?></div>


    <?php
    if ($listaPaginacao != null) {
        foreach ($listaPaginacao as $prod) {

            $precoExib = "R$ " . str_replace(".", ",", $prod->getPreco());
            ?>

            <div class="row dvExib">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-7">
                   <img src="img/produtos/<?= $prod->getImagem(); ?>" class="imgProdutoExib" alt="" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 dvExibSpan">
                    <a href="?pagina=detalhesprod&cod=<?= $prod->getCod(); ?>&pag=<?= $pag ?>&tipo=<?= $tipo ?>&termo=<?= $termo ?>" class="linkDetalhesProd"><?= $prod->getNome(); ?><br /><?= $precoExib; ?></a>
              </div>
            </div>
            <?php
        }
        ?>

        <!-- Paginação - front -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php
                $fila = ($pag % 5 == 0) ? $pag / 5 : floor(($pag / 5)) + 1;
                $pagAtual = $pag;
               
                //botao voltar
                if ($pagAtual > 5) {
                    ?>
                   
                    <li>
                        <a href="?pagina=produtos&pag=<?= ($fila * 5) - 5; ?>&tipo=<?= $tipo ?>&termo=<?= $termo ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php
                }

                //loop botoes numericos(blocos)
                for ($i = 4; $i >= 0; $i --) {
                    $valor = ($fila * 5) - $i;
                    $destacado = ($valor == $pagAtual) ? "color:orange;" : "";
                    ?>
                    <li><a style="<?= $destacado ?>" href="?pagina=produtos&pag=<?= $valor ?>&tipo=<?= $tipo ?>&termo=<?= $termo ?>"><?= $valor ?></a></li>
                    <?php
                    if ($valor == $blocos) {
                        $prev = false;
                        break;
                    }
                }

                //botao avançar
                if ($prev) {
                    ?>
                    <li>
                        <a href="?pagina=produtos&pag=<?= ($fila * 5) + 1 ?>&tipo=<?= $tipo ?>&termo=<?= $termo ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </nav>
</div>


<script language= 'javascript'>

    $("#btnBusca").click(function () {

        var tipo = $("#slTipo").val();

        var termo = $("#txtBusca").val();

        document.location.href = '?pagina=produtos&pag=1&tipo=' + tipo + '&termo=' + termo;
    });


</script>