<?php
require_once '../controller/AdministradorController.php';
require_once '../model/Administrador.php';

$admController = new AdministradorController();
$adm = new Administrador();
$adm = $admController->pegarAdmCod($_SESSION['cod']);

$res = "";

//excluir
if (filter_input(INPUT_GET, "excluir", FILTER_SANITIZE_NUMBER_INT)) {
    
    $codExcluir = filter_input(INPUT_GET, "excluir", FILTER_SANITIZE_NUMBER_INT);
    
    if($admController->excluirAdm($codExcluir)){
       
       unlink("img/administradores/".$adm->getFoto());
       
       echo "<script>window.location.href='?pagina=logout'</script>";
    } else {
        $res = "<div role=\"alert\" class=\"alert alert-danger\">Erro ao tentar excluir conta.</div>";
    } 
    
}

//editar
if (filter_input(INPUT_POST, "btnEditar", FILTER_SANITIZE_STRING)) {
    $atualizaImg = false;


    $nome = filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING);


    $foto = $_FILES['flImagem'];

    if ($foto['error'] != 4) {
        $atualizaImg = true;
        
        require_once ('../util/UploadFile.php');
        $upfoto = new Upload();
         unlink("img/administradores/<?= $adm->getFoto() ?>");
        
        $imagemFinal = $upfoto->LoadFile("img/administradores", "img", $foto);
        $adm->setFoto($imagemFinal);
        
    }

    $adm->setNome($nome);

    if ($admController->editarAdm($adm, $atualizaImg)) {
	   $_SESSION['nome'] = $nome;
        $res = "<div role=\"alert\" class=\"alert alert-success\">Perfil editado com sucesso.</div>";
    } else {
        $res = "<div role=\"alert\" class=\"alert alert-danger\">Erro ao tentar editar perfil.</div>";
    }
}
?>
<div class="panel panel-default">
<div class="panel panel-heading">
    Seu perfil
</div>

<div class="panel panel-body">
    <div><?= $res ?></div>
    <div id="dvImagem">
         <img src="img/administradores/<?= $adm->getFoto() ?>" id="imgAdm" alt="" />
    </div>
    <form method="post" enctype="multipart/form-data">
    
        <label for="flImagem">Mudar foto:</label>
        <input type="file" name="flImagem" id="flImagem" accept="img/*" />

        <label for="txtNome">Nome:</label><br />
        <input type="text" name="txtNome" id="txtNomeAdm" minlength="3" title="Deve conter pelo menos 3 caracteres." value="<?= $adm->getNome() ?>"/><br /><br />

        <label for="txtEmail">Email:</label><br />
        <input type="email" name="txtEmail" id="txtEmailAdm" title="Forneça um endereço de email válido." value="<?= $adm->getEmail() ?>" /><br /><br />

        <input type="submit" class="btn btn-success" name="btnEditar" value="Editar" />

    </form>
    <br /><br />
    <a href="#" onclick="return confirmar(<?= $adm->getCod() ?>)" class="btn btn-danger" name="btnExcluir">Excluir conta</a>
    <a href="?pagina=mudarSenha" class="btn btn-info" name="btnMudarSenha">Mudar senha</a>
      
</div>
</div>
    
<script>
    function confirmar(cod){
        if(confirm("Tem certeza de que deseja excluir sua conta?")){
            window.location.href = '?pagina=perfil&excluir=' + cod;
        }
    }
    
    
</script>