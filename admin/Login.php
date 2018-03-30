<?php
ini_set('display_errors', 0 );
error_reporting(0);

if (filter_input(INPUT_POST, "btnLogin", FILTER_SANITIZE_STRING)) {
    require_once "controller/AdministradorController.php";
    require_once "model/Administrador.php";

    $admController = new AdministradorController();


    $email = filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING);
    $adm = new Administrador();

    if (($adm = $admController->pegarAdmLogin($email, $senha)) != null) {
        session_start();
        $_SESSION['cod'] =  $adm->getCod() ;
        $_SESSION['nome'] =  $adm->getNome();
        
        
        ?><script>location.href = "admin/index.php";</script><?php
        
    } else {
        ?>

        <script>
            $(document).ready(function () {
                $("#msgErroLogin").html("<div role=\"alert\" class=\" alert alert-danger\">Não foi possível logar. Por favor, tente novamente.</div>");
            });
        </script>
        <?php
    }
}
?>

<div class="panel panel-default">
    <div class="panel panel-heading">
        Login do administrador
    </div>


    <div id="formulario" class="panel panel-body">
        <div id="msgErroLogin"></div>
        
        <!-- Formulário -->
        <form id="frmLogin" method="post">
            <label for="txtEmailLogin">Email:</label>
            <input type="email" name="txtEmail" id="txtEmailLogin"/>
            
            <label for="txtSenhaLogin">Senha:</label>
            <input type="password" name="txtSenha" id="txtSenhaLogin"/> 
            
            <input type="submit" class="btnSubmit" name="btnLogin" value="Entrar"/>
        </form>
        
        <a href="index.php" class="voltarLogin">Voltar</a>
    </div>

</div>   

