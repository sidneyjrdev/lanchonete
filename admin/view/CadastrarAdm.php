<?php
require_once "../controller/AdministradorController.php";
$admController = new AdministradorController();
$res = " ";
$listaEmails = [];
$listaEmails = $admController->pegarListaEmails();
$emailValido = true;

if (filter_input(INPUT_POST, "btnCadAdm", FILTER_SANITIZE_STRING)) {
    require_once ('../model/Administrador.php');
    $adm = new Administrador();

    require_once ('../util/UploadFile.php');
    $upfoto = new Upload();

    $nome = filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING);
    $foto = $_FILES['foto'];

    foreach ($listaEmails as $item) {
        if ($email === $item['email']) {
            $emailValido = false;
            break;
        }
    }

    if ($emailValido) {
        $imagemFinal = $upfoto->LoadFile("img/administradores", "img", $foto);

        $adm->setNome($nome);
        $adm->setEmail($email);
        $adm->setSenha($senha);
        $adm->setFoto($imagemFinal);


        if ($admController->cadastrarAdm($adm)) {

            $res = "<div role=\"alert\" class=\"alert alert-success\">Cadastro feito com sucesso.</div>";
        } else {
            $res = "<div role=\"alert\" class=\"alert alert-danger\">Erro ao tentar cadastrar.</div>";
        }
    } else {
        $res = "<div role=\"alert\" class=\"alert alert-danger\">Erro ao tentar cadastrar. Email já existente.</div>";
    }
}
?>

<div class="panel panel-default">
    <div class="panel panel-heading">
        Cadastrar administrador
    </div>

    <div class="panel panel-body">
        <div class="resultado"><?= $res ?></div>
        <form name="frmAdmNovo" class="frmCadAdm" method="post" enctype="multipart/form-data">

            <label for="txtNome">Nome:</label>
            <input type="text" class="form-group" name="txtNome" id="txtNome" minlength="3" required="required" title="Preencha o campo, e com pelo menos 3 caracteres"/><br />

            <label for="txtEmail">Email:</label>
            <input type="email" class="form-group" name="txtEmail" id="txtEmail" required="required" title="Forneça um endereço de email válido"/><br />

            <label for="txtSenha">Senha:</label>
            <input type="password" class="form-group" name="txtSenha" id="txtSenha" minlength="6" required="required" title="Preencha o campo, e com pelo menos 6 caracteres"/><br />

            <label for="foto">Foto:</label>
            <input type="file" class="form-group" name="foto" id="foto" accept="img/*" required="required" title="Selecione uma foto"/><br />

            <input type="submit" class="form-group btn btn-success btnCadAdm" name="btnCadAdm"/>
        </form>
    </div>
</div>

