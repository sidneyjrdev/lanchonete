<?php
session_start();
if (isset($_SESSION['cod'])) {
    echo "<script>window.location.href = 'admin/index.php'</script>";
} else {
    session_destroy();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Lanchonete</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="Lanchonete, lanches">
        <meta name="author" content="Sidney Junnior">
        <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <link href="jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/script.js" type="text/javascript"></script> 
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="js/datepicker-ptBR.js" type="text/javascript"></script>
        <script src="js/jquery.jcarousel.min.js" type="text/javascript"></script>
        <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
        <script src="js/jquery.maskMoney.min.js" type="text/javascript"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">  
        <link rel="shortcut icon" type="image/png" href="img/hamburguer005.gif"/>
    </head>
    <body>

        <div class="container">

            <!-- cabeçalho -->

            <div class="cabecalho">
                <ul class="redes-sociais hidden-xs">
                    <li><a href="http://www.facebook.com"><img src="img/facebook.png" alt="facebook"/></a></li>
                    <li><a href="http://www.twitter.com"><img src="img/twitter.png" alt="twitter"/></a></li>
                    <li><a href="http://www.instagram.com"><img src="img/instagram.png" alt="instagram"/></a></li>
                </ul>
                <img src="img/logo.png" alt="" class="imgLogo hidden-xs"/>
                <img src="img/logocelular.png" alt="" class="imgLogoCelular visible-xs"/>

                <span id="spEndereco">
                    Rua Vaz Lobo, 50, Centro - Rio de Janeiro
                </span>


                <a href="?pagina=login" class="btn btn-primary btnPainel hidden-xs">
                    Painel do administrador
                </a>


                <span id="spFuncionamento">
                    Horário de funcionamento:<br>
                    Segunda a sábado das 10:00 às 22:00hs
                </span>

            </div>



            <!-- menu -->
            <div class="menu">
                <ul class="menu-site">
                    <li><a href="?pagina=home">Home</a></li>
                    <li><a href="?pagina=produtos">Produtos</a></li>
                    <li><a href="?pagina=simulacao">Simule seu pedido</a></li>
                    <li><a href="?pagina=sobreNos">Quem somos</a></li>
                    <li><a href="?pagina=contato">Contato</a></li>
                </ul>
            </div>

            <!-- menu celular-->
            <div class="clearfix"></div>
            <button class="btn btn-info btnMenuCelular visible-xs"><span class="glyphicon glyphicon-menu-hamburger"></span></button>

            <ul class="menu-celular hidden-lg hidden-md">
                <li><a href="?pagina=home">Home</a></li>
                <li><a href="?pagina=produtos">Produtos</a></li>
                <li><a href="?pagina=simulacao">Simule seu pedido</a></li>
                <li><a href="?pagina=sobreNos">Quem somos</a></li>
                <li><a href="?pagina=contato">Contato</a></li>
            </ul>

            <!-- div celular-->
            <div class="clearfix"></div>
            <div class="dvInfo hidden-lg hidden-md">

                <a href="?pagina=login" class="btn btn-primary btn-xs btnPainel visible-xs">
                    Painel adm
                </a>

                <span>
                    Rua Vaz Lobo, 50, Centro - Rio de Janeiro
                </span><br />

                <span>
                    Funcionamos de Seg a Sáb das 10:00 às 22:00hs.
                </span>

            </div>

            <!-- inclusão da página -->

            <?php
            require_once("util/incluirCaminho.php");
            ?>

            <!-- rodapé -->

            <div class="rodape">
                <span id="spRodape">Lanchonete &copy; - Todos os direitos reservados</span>

                <!-- redes sociais celular -->
                <ul class="redes-sociais-celular visible-xs">
                    <li><a href="http://www.facebook.com"><img src="img/facebook.png" alt="facebook"/></a></li>
                    <li><a href="http://www.twitter.com"><img src="img/twitter.png" alt="twitter"/></a></li>
                    <li><a href="http://www.instagram.com"><img src="img/instagram.png" alt="instagram"/></a></li>
                </ul>
            </div>
        </div>
    </body>
</html>
