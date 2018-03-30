<?php

if(isset($_SESSION['cod'])){
require_once "../DAL/DestaqueDAO.php";
}
else{
require_once "DAL/DestaqueDAO.php";   
}

class DestaqueController {

    private $destaqueDAO;
    
    public function __construct() {
        $this->destaqueDAO = new DestaqueDAO();
    }

    public function pegarTodos() {
      return $this->destaqueDAO->pegarTodos();
        
    }
    
    public function exibicaoHome() {
      return $this->destaqueDAO->exibicaoHome();
        
    }
    
    public function pegarImagem($cod) {
     if ($cod > 0) {
           return $this->destaqueDAO->pegarImagem($cod);
            
        } else {
            return null;
        }
        
    }

    public function excluir($cod) {
        
        if ($cod > 0) {
           return $this->destaqueDAO->excluir($cod);
            
        } else {
            return false;
        }
    }

    public function inserir($destaque) {
        if ($destaque != null) {
            return $this->destaqueDAO->inserir($destaque);
        } else {
            return false;
        }
    }
    
    
    public function retirarExibicao($cod){
        if ($cod > 0) {
           return $this->destaqueDAO->retirarExibicao($cod);
            
        } else {
            return false;
        }
    }
    
    public function incluirExibicao($cod){
        if ($cod > 0) {
           return $this->destaqueDAO->incluirExibicao($cod);
            
        } else {
            return false;
        }
    }

}
