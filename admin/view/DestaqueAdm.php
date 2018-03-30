<?php
date_default_timezone_set('America/Sao_Paulo');

require_once "../controller/DestaqueController.php";
require_once "../model/Destaque.php";
require_once "../util/Modif_Datas_e_Precos.php";
$modifDatas = new Modif_Datas_e_Precos();
$destaqueController = new DestaqueController();
$mensagem = " ";
//botao cadastro
if (filter_input(INPUT_POST, "btnCadastrar", FILTER_SANITIZE_STRING)) {
    require_once ("../util/UploadFile.php");
    $uploadFile = new Upload();
    $destaque = new Destaque();
    $imagem = $_FILES['imgDestaque'];
    $dataExpiracao = filter_input(INPUT_POST, "dataExp", FILTER_SANITIZE_STRING);
    $inseridoPor = $_SESSION['cod'];
    $imagemFinal = $uploadFile->LoadFile("../img/destaques/", "img", $imagem);
    $dataExpiracao = $modifDatas->CadastrarData($dataExpiracao);
    $destaque->setImagem($imagemFinal);
    $destaque->setDataExpiracao($dataExpiracao);
    $destaque->setStatusExibicao(0);
    $destaque->setAdministrador($inseridoPor);
    if (!($destaqueController->inserir($destaque))) {
        $mensagem = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar cadastrar.</div>";
    } else {
        $mensagem = "<div class=\"alert alert-success\" role=\"alert\">Destaque cadastrado com sucesso.</div>";
    }
}
//botão exibição
if (filter_input(INPUT_GET, "codexibido", FILTER_SANITIZE_NUMBER_INT)) {
    $codExibido = filter_input(INPUT_GET, "codexibido", FILTER_SANITIZE_NUMBER_INT);
    $valorExibicao = filter_input(INPUT_GET, "valor", FILTER_SANITIZE_STRING);
   
    if ($valorExibicao == "Retirar exibição") {
        if ($destaqueController->retirarExibicao($codExibido)) {
            $mensagem = "<div class=\"alert alert-success\" role=\"alert\">Exibição retirada com sucesso.</div>";
        }else{
            $mensagem = "<div class=\"alert alert-danger\" role=\"alert\">Erro ao tentar retirar exibição.</div>";
        }
    } else if ($valorExibicao == "Incluir exibição"){
       
            if ($destaqueController->incluirExibicao($codExibido)) {
                $mensagem = "<div class=\"alert alert-success\" role=\"alert\">Exibição incluída com sucesso.</div>";
            }
            else{
                $mensagem = "<div class=\"alert alert-danger\" role=\"alert\">Erro ao tentar incluir exibição.</div>"; 
            }
        }
    }
//Excluir
if (filter_input(INPUT_GET, "excluir", FILTER_SANITIZE_NUMBER_INT)) {
    $codExcluir = filter_input(INPUT_GET, "excluir", FILTER_SANITIZE_NUMBER_INT);
    $destExc = new Destaque();
    $destExc = $destaqueController->pegarImagem($codExcluir);
    $imgExc = $destExc->getImagem();
    if ($destaqueController->excluir($codExcluir)) {
        $mensagem = "<div class=\"alert alert-success\" role=\"alert\">Destaque excluído com sucesso.</div>";
        unlink("../img/destaques/" . $imgExc);
    } else {
        $mensagem = "<div class=\"alert alert-danger\" role=\"alert\">Houve um erro ao tentar excluir.</div>";
    }
}
?>


<div class="panel panel-default">
    <div class="panel panel-heading">
        Gerenciar destaques e promoções
    </div>


    <!--Cadastrar -->
    <?php
    if (filter_input(INPUT_GET, "cadastrar", FILTER_SANITIZE_STRING)) {
        ?>

        <!-- formulario -->

        <div class="panel panel-body">
            <a href="?pagina=destaques" id="voltar-exibicao" class="btn btn-info">Voltar à exibição</a>
            <div class="mensagem">
                <?= $mensagem; ?>
            </div>
            
            <span id="obsDestaque">Obs.: Para habilitar a visualização na Home, 
                     depois do cadastro clique na aba "Destaques e Promoções" do menu.</span>

            <div class="row">
                <div class="col-lg-12"> 
                <form name="frmCadastrarDestaque" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="imgDestaque">Selecione a imagem do(a) destaque/promoção: </label>
                        <input type="file" name="imgDestaque" id="imgDestaque" accept="img/*" required="required" title="Selecione uma imagem"/>
                    </div>   
                    <div class="form-group">
                        <label for="dataDestaque">Data de expiração da promoção. (A partir desta data, ela não será mais exibida na home. É opcional.)</label>
                        <input type="text" name="dataExp" id="dataDestaque" minlength="10" title="Data inválida. Use o calendário exibido para selecionar a data."/>
                    </div>
                    
                    <input type="submit" name="btnCadastrar" value="Cadastrar" class="btn btn-success btnDestaque"/>
                </form> 
            </div>
            </div>
        </div>
        <?php
    } else {
        //Exibir todos
        $listaDestaques = $destaqueController->pegarTodos();
        ?>
        
        <!--Mostrar todos-->
        <div class="panel panel-body">
            <a href="?pagina=destaques&cadastrar=sim" class="btn btn-success btnNovoDestaque">Cadastrar destaque/promoção</a>
            <div class="mensagem">
                <?= $mensagem; ?>
            </div>
            
            <?php
            if ($listaDestaques != null) {
                foreach ($listaDestaques as $dest) {
                    $exibido = ($dest->getStatusExibicao() == 1) ? "Retirar exibição" : "Incluir exibição";
                    ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <img  src="../img/destaques/<?= $dest->getImagem(); ?>" class="img-destaque" alt="" />
                        </div>
                        <div class="col-lg-8 alignCenter" id="dvDesc">
                            <p>Data de expiração: <?= $dest->getDataExpiracao() == null? " Não tem" : $modifDatas->ExibirData($dest->getDataExpiracao()); ?></p>
                            <p>Inserido por: <?= $dest->getAdministrador()->getNome(); ?></p>
                            <?php if((strtotime($dest->getDataExpiracao()) >= strtotime("now")) || $dest->getDataExpiracao() == null){ ?>
                            <a href="?pagina=destaques&codexibido=<?= $dest->getCod() ?>&valor=<?= $exibido ?>"  id="btnExibicao" class="btn btn-info"><?= $exibido ?></a>
                            <?php } ?>
                            <a href="#" onclick="return confirmar(<?= $dest->getCod() ?>)" class="btn btn-danger btnExcluirDestaque ">Excluir</a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

        </div>

    <?php } ?>


</div>

<script language='javascript'>
    function confirmar(id) {
        if (confirm("Deseja realmente excluir o destaque?")) {
            window.location.href = '?pagina=destaques&excluir=' + id;
        }
    }
   
</script>