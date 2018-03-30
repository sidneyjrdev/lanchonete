<?php
require_once("../controller/ProdutoController.php");
require_once("../model/Produto.php");
require_once("../util/Modif_Datas_e_Precos.php");

$modif = new Modif_Datas_e_Precos();
$produtoController = new ProdutoController();
$mensagem = "";

//função slug
function slug($string) {
    return preg_replace(array('/([`^~\'"])/', '/([-]{2,}|[-+]+|[\s]+)/', '/(,-)/'), array(null, '-', ', '), iconv('UTF-8', 'ASCII//TRANSLIT', $string));
}

//cadastrar - back
if (filter_input(INPUT_POST, "btnCadastrar", FILTER_SANITIZE_STRING)) {

    $nome = filter_input(INPUT_POST, "txtNomeCad", FILTER_SANITIZE_STRING);
    $tipo = filter_input(INPUT_POST, "slTipoCad", FILTER_SANITIZE_NUMBER_INT);
    $descricao = filter_input(INPUT_POST, "txtDescricaoCad", FILTER_SANITIZE_STRING);

    $preco = filter_input(INPUT_POST, "txtPrecoCad", FILTER_SANITIZE_NUMBER_FLOAT);
    $preco = $modif->CadastrarDinheiro($preco);

    $slug = slug(filter_input(INPUT_POST, "txtNomeCad", FILTER_SANITIZE_STRING));
    $imagem = $_FILES['flImagemCad'];
    $adm = $_SESSION['cod'];

    require_once ("../util/UploadFile.php");
    $uploadFile = new Upload();
    $imagemFinal = $uploadFile->LoadFile("../img/produtos/", "img", $imagem);

    $produto = new Produto();
    $produto->setNome($nome);
    $produto->setTipo($tipo);
    $produto->setDescricao($descricao);
    $produto->setPreco($preco);
    $produto->setSlug($slug);
    $produto->setImagem($imagemFinal);
    $produto->setAdministrador($adm);

    if ($produtoController->inserir($produto)) {
        $mensagem = "<div class=\"alert alert-success\" role=\"alert\">Produto cadastrado com sucesso.</div>";
        echo "<a href=\"?pagina=produtos\" class=\"btn btn-info\">Voltar à exibição</a>";
    } else {
        $mensagem = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar cadastrar.</div>";
        echo "<a href=\"?pagina=produtos\" class=\"btn btn-info\">Voltar à exibição</a>";
    }
}

//paginação - back

$pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT) : 1;
$ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_STRING) : "nome";
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
$listaPaginacao = $produtoController->pegarFiltro($tipo, $ordem, $offset, $qtdExibida, $termo);

if ($qtdTotalProdutos == 0) {
    $mensagem = "<div role=\"alert\" class=\"alert alert-danger\">Não há produtos a serem exibidos.</div>";
}
?>

<div class="panel panel-default">
    <div class="panel panel-heading">
        Gerenciar produtos
    </div>

    <!--Cadastrar - front -->
<?php
if (filter_input(INPUT_GET, "cadastrar", FILTER_SANITIZE_STRING)) {
    ?>
        <div class="panel panel-body">
            <div><?= $mensagem ?></div>
            <!-- formulario -->
            <form name="frmCadastrarProduto" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="flImagemCad">Imagem</label>
                    <input type="file" class="form-control" name="flImagemCad" id="flImagemCad" accept="img/*" required="required" title="Selecione uma imagem."/>
                </div>

                <div class="form-group">
                    <label for="txtNomeCad">Nome</label>
                    <input type="text" class="form-control" name="txtNomeCad" id="txtNomeCad" minlength="3" required="required" title="Deve ser preenchido e conter pelo menos 3 caracteres."/>
                </div>

                <div class="form-group">
                    <label for="slTipoCad">Tipo</label>
                    <select id="slTipoCad" class="form-control" name="slTipoCad">
                        <option value="1">sanduiche</option>
                        <option value="2">acompanhamento</option>
                        <option value="3">bebida</option>
                        <option value="4">ingrediente</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="txtDescricaoCad">Descrição</label>
                    <textarea class="form-control" name="txtDescricaoCad" id="txtDescricaoCad" minlength="10" required="required" title="Deve ser preenchido e conter pelo menos 10 caracteres."></textarea>
                </div>

                <div class="form-group">
                    <label for="txtPrecoCad">Preço(R$)</label>
                    <input type="text" class="form-control" name="txtPrecoCad" id="txtPrecoCad" required="required" title="Deve ser preenchido." placeholder="Ex.: 8,46" />
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success" name="btnCadastrar" value="Cadastrar" />
                </div>
            </form>
            <a href="?pagina=produtos" class="btn btn-primary">Voltar</a>
        </div>
<?php } else { ?>

        <!-- Mostrar -->
        <div class="panel panel-body">
            <div class="row">
                <a href="?pagina=produtos&cadastrar=sim" class="btn btn-info" id="btnCadastroProd">Cadastrar produto</a> 
            </div>

            <select name="slTipo" id="slTipo">
                <option <?= ($tipo == 0) ? "selected" : "" ?> value="0">Todos</option>
                <option <?= ($tipo == 1) ? "selected" : "" ?> value="1">Sanduíches</option>
                <option <?= ($tipo == 2) ? "selected" : "" ?> value="2">Acompanhamentos</option>
                <option <?= ($tipo == 3) ? "selected" : "" ?> value="3">Bebidas</option>
                <option <?= ($tipo == 4) ? "selected" : "" ?> value="4">Ingredientes</option>
            </select>
            <select name="slOrdenar" id="slOrdenar">
                <option <?= ($ordem == "nome") ? "selected" : "" ?> value="nome">Ordenar por : nome</option>
                <option <?= ($ordem == "data_mod") ? "selected" : "" ?> value="data_mod">Ordenar por : data da última modificação</option>
            </select>
            <input type="text" id="txtBusca" name="txtBusca" value="<?= $termo ?>"  placeholder="Digite sua busca(opcional)."/>
            <button class="btn btn-success" id="btnBuscaAdm" name="btnBusca">Buscar</button>  

        </div>


        <div class="mensagem"><?= $mensagem; ?></div>


    <?php
    if ($listaPaginacao != null) {
        ?>
            <!-- Tabela com os produtos detalhados -->
            <div class="dvTabelaProdAdm">
                <table class="table table-responsive table-bordered" id="tabProdAdm">
                    <thead>
                        <tr class="bg-primary">
                            <td>Imagem</td>
                            <td>Nome</td>
                            <td>Preço</td>
                            <td>Data da última modificação</td>
                            <td>Inserido por</td>
                            <td>Ações</td>
                        </tr>
                    </thead>

                    <tbody>
        <?php
        foreach ($listaPaginacao as $prod) {
            $dataExib = $modif->ExibirData($prod->getDataUltimaModific());
            $precoExib = "R$ " . str_replace(".", ",", $prod->getPreco());
            ?>

                            <tr class="bg-info">
                                <td><img  src="../img/produtos/<?= $prod->getImagem(); ?>" class="imgProdutoExib" alt="" /></td>
                                <td><?= $prod->getNome(); ?></td>
                                <td><?= $precoExib; ?></td> 
                                <td><?= ($dataExib == null) ? "-" : $dataExib ?></td>
                                <td><?= $prod->getAdministrador()->getNome(); ?></td>
                                <td>
                                    <a href="?pagina=produtosEdicao&editar=<?= $prod->getCod(); ?>" class="btn btn-warning">Editar</a>
                                    <a href="#" onclick="return confirmar(<?= $prod->getCod() ?>);" class="btn btn-danger">Excluir</a>

                                </td>
                            </tr>

            <?php
        }
        ?>
                    </tbody>
                </table> 
            </div>
            <!-- Paginação - front -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
        <?php
        $fila = ($pag % 5 == 0) ? $pag / 5 : floor(($pag / 5)) + 1;
        $pagAtual = $pag;

        //botao voltar
        if ($pag > 5) {
            ?>
                        <li>
                            <a href="?pagina=produtos&pag=<?= ($fila * 5) - 5; ?>&tipo=<?= $tipo ?>&ordem=<?= $ordem ?>&termo=<?= $termo ?>" aria-label="Previous">
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
                        <li><a style="<?= $destacado ?>" href="?pagina=produtos&pag=<?= $valor ?>&tipo=<?= $tipo ?>&ordem=<?= $ordem ?>&termo=<?= $termo ?>"><?= $valor ?></a></li>
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
                            <a href="?pagina=produtos&pag=<?= ($fila * 5) + 1 ?>&tipo=<?= $tipo ?>&ordem=<?= $ordem ?>&termo=<?= $termo ?>" aria-label="Next">
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
<?php } ?>

<script language= 'javascript'>
    function confirmar(id) {
        if (confirm("Tem certeza que deseja excluir o produto?")) {
            window.location.href = '?pagina=produtosEdicao&excluir=' + id;
        }
    }

    $("#btnBuscaAdm").click(function () {

        var tipo = $("#slTipo").val();

        var ordem = $("#slOrdenar").val();

        var termo = $("#txtBusca").val();

        document.location.href = '?pagina=produtos&pag=1&tipo=' + tipo + '&ordem=' + ordem + '&termo=' + termo;
    });


</script>