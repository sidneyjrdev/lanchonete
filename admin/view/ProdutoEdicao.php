<?php
require_once("../controller/ProdutoController.php");
require_once("../model/Produto.php");
require_once("../util/Modif_Datas_e_Precos.php");


date_default_timezone_set('America/Sao_Paulo');

$produtoController = new ProdutoController();


//Editar btnEditar
if (filter_input(INPUT_POST, "btnEditar", FILTER_SANITIZE_STRING)) {

    $cod = filter_input(INPUT_POST, "cod", FILTER_SANITIZE_NUMBER_INT);
    $imagem = $_FILES['flImagem'];
    $nome = filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING);
    $tipo = filter_input(INPUT_POST, "slTipo", FILTER_SANITIZE_STRING);
    $descricao = filter_input(INPUT_POST, "txtDescricao", FILTER_SANITIZE_STRING);
    $preco = filter_input(INPUT_POST, "txtPreco", FILTER_SANITIZE_NUMBER_FLOAT);

    $modif = new Modif_Datas_e_Precos();
    $preco = $modif->CadastrarDinheiro($preco);

    $prodUp = new Produto();

    $prodUp->setCod($cod);
    $prodUp->setDataUltimaModific(date('Y-m-d'));
    $prodUp->setNome($nome);
    $prodUp->setTipo($tipo);
    $prodUp->setDescricao($descricao);
    $prodUp->setPreco($preco);


    $atualizaImg = false;

    if ($imagem['error'] != 4) {
        require_once("../util/UploadFile.php");
        $upfile = new Upload();
        $imagemFinal = $upfile->LoadFile("../img/produtos", "img", $imagem);
        $prodUp->setImagem($imagemFinal);
        $atualizaImg = true;
    }

    if ($produtoController->editar($prodUp, $atualizaImg)) {

        echo "<div role=\"alert\" class=\"alert alert-success\">Produto editado com sucesso.</div>";
        echo "<a href=\"?pagina=produtos\" class=\"btn btn-info\">Voltar à exibição</a>";
        exit;
    } else {

        echo "<div role=\"alert\" class=\"alert alert-danger\">Erro ao tentar editar produto.</div>";
        echo "<a href=\"?pagina=produtos\" class=\"btn btn-info\">Voltar à exibição</a>";
        exit;
    }
}

//Editar(visualização) - back
if (filter_input(INPUT_GET, "editar", FILTER_SANITIZE_NUMBER_INT)) {
    $prod = new Produto();
    $prod = $produtoController->pegarUm(filter_input(INPUT_GET, "editar", FILTER_SANITIZE_NUMBER_INT));
    $precoExib = str_replace(".", ",", $prod->getPreco());
    if ($prod == null) {
        echo "<div role=\"alert\" class=\"alert alert-danger\">Erro ao exibir produto para edição</div>";
        echo "<a href=\"?pagina=produtos\" id=\"voltar-exibicao-prod\" class=\"btn btn-info\">Voltar à exibição</a>";
    }
}


//Excluir - back
if (filter_input(INPUT_GET, "excluir", FILTER_SANITIZE_NUMBER_INT)) {

    $codExcluir = filter_input(INPUT_GET, "excluir", FILTER_SANITIZE_NUMBER_INT);
    $prodExc = new Produto();
    $prodExc = $produtoController->pegarUm($codExcluir);
    $imgExc = $prodExc->getImagem();
    
    if ($produtoController->excluir($codExcluir)) {
        unlink("../img/produtos/".$imgExc);
        echo "<div role=\"alert\" class=\"alert alert-success\">Produto excluído com sucesso.</div>";
        echo "<a href=\"?pagina=produtos\" id=\"voltar-exibicao-prod\" class=\"btn btn-info\">Voltar à exibição</a>";
        exit;
    } else {
        echo "<div role=\"alert\" class=\"alert alert-danger\">Erro ao excluir produto.</div>";
        echo "<a href=\"?pagina=produtos\" id=\"voltar-exibicao-prod\" class=\"btn btn-info\">Voltar à exibição</a>";
        exit;
    }
}
?>
<div class="panel panel-default">
    <div class="panel panel-heading">
        Editar produto
    </div>
    <div class="panel-body">
<div class="alignCenter">
<img src="../img/produtos/<?= $prod->getImagem(); ?>" id="imgProdutoEdicao" alt=""/>
</div>

<!--Editar - front --> 
<form name="frmEditarProduto" method="post" enctype="multipart/form-data">
    
    <div class="form-group">
    <label for="flImagem">Mudar imagem</label>
    <input type="file" class="form-control" name="flImagem" id="flImagem" accept="img/*" />
    </div>
    
    <div class="form-group">
    <label for="txtNome">Nome</label>
    <input type="text" class="form-control" required="required" name="txtNome" id="txtNome" value="<?= $prod->getNome(); ?>" minlength="3" title="Deve conter pelo menos 3 caracteres."/>
    </div>
    
    <div class="form-group">
    <label for="slTipo">Tipo</label>
    <select id="slTipo" class="form-control" name="slTipo">
        <option <?= ($prod->getTipo() == 1) ? "selected" : "" ?> value="1">sanduiche</option>
        <option <?= ($prod->getTipo() == 2) ? "selected" : "" ?> value="2">acompanhamento</option>
        <option <?= ($prod->getTipo() == 3) ? "selected" : "" ?> value="3">bebida</option>
        <option <?= ($prod->getTipo() == 4) ? "selected" : "" ?> value="4">ingrediente</option>
    </select>
    </div>

    <div class="form-group">
    <label for="txtDescricao">Descrição</label>
    <textarea class="form-control" name="txtDescricao" id="txtDescricao" required="required" minlength="10" title="Deve conter pelo menos 10 caracteres."><?= $prod->getDescricao() ?></textarea>
    </div>
    
    <div class="form-group">
    <label for="txtPreco">Preço(R$)</label>
    <input type="text" class="form-control" required="required" name="txtPreco" id="txtPreco" placeholder="Ex.: 8,46" value="<?= $precoExib ?>"/>
    </div>
    
    <input type="hidden" name="cod" value="<?= $prod->getCod() ?>">

    <div class="form-group">
    <input type="submit" class="btn btn-success" name="btnEditar" value="Editar" />
    </div>

</form>
<a href="?pagina=produtos" class="btn btn-primary">Voltar</a>
</div>
</div>


