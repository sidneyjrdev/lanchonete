<?php
require_once 'controller/ProdutoController.php';
require_once 'model/Produto.php';

$produtoController = new ProdutoController();


$sanduiches = $produtoController->pegarTipo(1);
$ingredientes = $produtoController->pegarTipo(4);
$acompanhamentos = $produtoController->pegarTipo(2);
$bebidas = $produtoController->pegarTipo(3);
?>
<div class="panel panel-default">
    <div class="panel panel-heading">
        <strong>Simule seu pedido</strong>
    </div>

    <div class="panel panel-body dvSimulacao">
        <span id="obsSimulacao">Obs.: Esta simulação não leva em conta as promoções. Confira-as na home de nosso site.</span>
        <form id="frmSimulacao">
            
                <span class="spanSimulacao">Pão</span> 
                <input type="radio" name="pao" value="4.00" checked="checked"/>15 cm. - R$ 4,00
                <input type="radio" name="pao" value="8.00"/>30 cm. - R$ 8,00  
            
                <span class="spanSimulacao">Sanduíche</span>
                <select name="slSanduiches">
                    <?php
                    foreach ($sanduiches as $sanduiche) {
                        ?>

                        <option value="<?= $sanduiche->getPreco(); ?>"><?= $sanduiche->getNome(); ?></option>

                    <?php } ?>
                </select>
            
                <span class="spanSimulacao">Ingredientes</span>
                <div class="row">
     <div class="col-lg-6">
                <?php
                $numIngredientes = count($ingredientes);
                $metadeSeparar = ceil(($numIngredientes) / 2);
                $i = 1;
                foreach ($ingredientes as $ingrediente) {
                    ?>
                    <input type="checkbox" name="chIngredientes[]" value="<?= $ingrediente->getPreco(); ?>"><?= $ingrediente->getNome(); ?><br />
                    <?php
                    if ($i == $metadeSeparar) {
                      ?>
     </div>
               
     <div class="col-lg-6">
                    <?php
                    }
                    $i++;
                }
                    ?>
         
     </div>
                </div>
            
            <span class="spanSimulacao">Acompanhamentos</span>
                <?php
                foreach ($acompanhamentos as $acompanhamento) {
                    ?>
                    <input type="checkbox" name="chAcompanhamento[]" value="<?= $acompanhamento->getPreco(); ?>"><?= $acompanhamento->getNome(); ?><br />
                <?php } ?>
            
                <span class="spanSimulacao">Bebida</span>
                <select name="slBebidas">
                    <option value="0.00">Selecione a bebida</option>
                    <?php
                    foreach ($bebidas as $bebida) {
                        ?>
                        <option value="<?= $bebida->getPreco(); ?>"><?= $bebida->getNome(); ?></option>
                    <?php } ?>
                </select>
            
        </form>
        <span class="spPrecoTotal">
            Total: R$ 0,00 
        </span>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#frmSimulacao").change(function () {
            CalcularPreco();
        });
    });

    function CalcularPreco() {

        var pao = parseFloat($("input[name='pao']:checked").val());

        var sanduiche = parseFloat($("select[name='slSanduiches'] option:selected").val());


        var totalIngredientes = 0.00;
        $("input[type=checkbox][name='chIngredientes[]']:checked").each(function () {
            totalIngredientes += parseFloat($(this).val());
        });

        var totalAcompanhamentos = 0.00;
        $("input[type=checkbox][name='chAcompanhamento[]']:checked").each(function () {
            totalAcompanhamentos += parseFloat($(this).val());
        });

        var bebida = parseFloat($("select[name='slBebidas'] option:selected").val());

        var precoTotal = (pao + sanduiche + totalIngredientes + totalAcompanhamentos + bebida).toFixed(2);


        precoTotal = precoTotal.toString();

        var precoExibir = "Total: "+ "R$ " + precoTotal.replace(".", ",");
        $(".spPrecoTotal").text(precoExibir);

    }
</script>