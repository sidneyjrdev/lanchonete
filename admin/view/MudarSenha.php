<?php
require_once '../controller/AdministradorController.php';
$admController = new AdministradorController();
$res = "";

if(filter_input(INPUT_POST, "btnMudarSenha", FILTER_SANITIZE_STRING)){
    $senha1 = filter_input(INPUT_POST, "senha1", FILTER_SANITIZE_STRING);
    $senha2 = filter_input(INPUT_POST, "senha2", FILTER_SANITIZE_STRING);
    $cod = $_SESSION['cod'];
    
    if($admController->mudarSenha($cod, $senha1)){
        $res = "<div role=\"alert\" class=\"alert alert-success\">Senha modificada com sucesso.</div>";
        echo "<a href=\"?pagina=perfil\" id=\"voltar-exibicao-perfil\" class=\"btn btn-info\">Voltar ao perfil</a>";
        
    } else {

        $res = "<div role=\"alert\" class=\"alert alert-danger\">Erro ao tentar mudar senha.</div>";
        echo "<a href=\"?pagina=perfil\" id=\"voltar-exibicao-perfil\" class=\"btn btn-info\">Voltar ao perfil</a>";
       
    } 
    }


?>

<div class="panel panel-default">
    <div class="panel panel-heading">
        Mudar senha
    </div>
    <div class="panel panel-body">
        <div><?= $res ?></div>
        <form method="post" id="frmMudarSenha">
            
            <label for="senha1">Digite sua nova senha: </label>
            <input type="password" name="senha1" id="senha1" minlength="6" title="Sua senha deve ter pelo menos 6 caracteres." oncopy="return false"/>
            <br /> <br />
            <label for="senha2">Repita a senha: </label>
            <input type="password" name="senha2" id="senha2" minlength="6" title="Sua senha deve ter pelo menos 6 caracteres."/><br /><br />
            
            <span id="resSenhas"></span><br /><br />
            <input type="submit" class="btn btn-success" id="btnMudarSenha" name="btnMudarSenha" value="Mudar senha"/>
        </form>
    </div>
</div>

<script>
    
    var conferem = false;
    $("#frmMudarSenha").submit(function(e){
        if(!conferem){
        e.preventDefault();
    }
    });
    
    $("input[type='password']").keyup(function(){
        
        var senha1 = $("#senha1").val();
        var senha2 = $("#senha2").val();
        
        if(senha1 !== senha2){
            $("#resSenhas").text('Senhas não coincidem!').css('color', 'red');
            conferem = false;
        }else{
            $("#resSenhas").text('Senhas coincidem.').css('color', 'green');
            conferem = true;
        }
    });
  
</script>