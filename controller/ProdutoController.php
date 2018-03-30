<?php
if(isset($_SESSION['cod'])){
require_once '../DAL/ProdutoDAO.php';
}else{
 require_once 'DAL/ProdutoDAO.php';   
}

class ProdutoController {

    private $produtoDAO;
    
    public function __construct() {
        $this->produtoDAO = new ProdutoDAO();
    }

    public function pegarQtdTotal($tipo, $termo) {
        

        if ($tipo >= 0 && $tipo < 5) {
            return $this->produtoDAO->pegarQtdTotal($tipo, $termo);
        } else {
            return 0;
        }
    }
    
     public function pegarFiltro($tipo, $ordem, $offset, $qtdExibida, $termo) {
       
        $arrayOrdem = array("nome", "data_mod");
        if ($tipo >= 0 && $tipo < 5 && in_array($ordem, $arrayOrdem) && $offset >= 0 && $qtdExibida > 0) {
            return $this->produtoDAO->pegarFiltro($tipo, $ordem, $offset, $qtdExibida, $termo);
            
        } else {
           
            return null;
        }
    }
    
    public function pegarTipo($tipo) {
        

        if ($tipo >= 1 && $tipo < 5) {
            return $this->produtoDAO->pegarTipo($tipo);
        } else {
            return null;
        }
    }

    public function pegarUm($cod) {
        if ($cod > 0) {
            return $this->produtoDAO->pegarUm($cod);
        } else {
            return null;
        }
    }

    public function excluir($cod) {
        if ($cod > 0) {
            return $this->produtoDAO->excluir($cod);
        } else {
            return false;
        }
    }

    public function editar($prod, $atualizaImg) {
        
        if (strlen($prod->getNome()) > 2 && $prod->getDataUltimaModific() != null && $prod->getTipo() > 0 && $prod->getTipo() < 5 &&
            strlen($prod->getDescricao()) > 9 && $prod->getPreco() > 0 && $prod->getImagem() != "invalid" && is_bool($atualizaImg)) {
            return $this->produtoDAO->editar($prod, $atualizaImg);
        }else{
            
            return false;
        }
    }
    
     public function inserir($prod) {
        
        if (strlen($prod->getNome()) > 2 && $prod->getTipo() > 0 && $prod->getTipo() < 5 &&
            strlen($prod->getDescricao()) > 9 && $prod->getPreco() > 0 && $prod->getImagem() != "invalid") {
            return $this->produtoDAO->inserir($prod);
        }else{
            return false;
        }
    }

}
