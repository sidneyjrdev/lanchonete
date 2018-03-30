<?php

class Modif_Datas_e_Precos{
private $arrayData = [];
private $novaData;
    
function ExibirData($data){
    if($data != null){
    $arrayData = explode("-", $data);
    $novaData = $arrayData[2] . "/" . $arrayData[1] . "/" . $arrayData[0];
    return $novaData;
    }else{
        return null;
    }
}

function CadastrarData($data){
    if($data != null){
    $arrayData = explode("/", $data);
    $novaData = $arrayData[2] . "-" . $arrayData[1] . "-" . $arrayData[0];
    return $novaData;
    }else{
        return null;
    }
}

function CadastrarDinheiro($valor){
   if($valor != null){
      $valor = $valor/100; //operação necessária devido a um erro no maskMoney
      $novoValor = sprintf("%.4f", $valor);
      $novoValor = str_replace(",", ".", $novoValor);
      return $novoValor;
      
   } else{
       return null;
   }
}

function ExibirDinheiro($valor){
    if($valor != null){
       
   } else{
       return null;
   }
}


}
