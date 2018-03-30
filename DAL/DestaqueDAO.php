<?php

require_once "Banco.php";

if (isset($_SESSION['cod'])) {
    require_once "../model/Destaque.php";
} else {
    require_once "model/Destaque.php";
}

class DestaqueDAO {

    private $banco;

    public function __construct() {
        $this->banco = new Banco();
    }

    function pegarTodos() {
        try {
            $sql = "SELECT d.*, a.nome FROM destaque d JOIN administrador a ON d.administrador_cod = a.cod";


            $listaRetorno = $this->banco->SelectVariasLinhas($sql);

            $listaDestaques = [];

            foreach ($listaRetorno as $item) {
                $destaque = new Destaque();
                $destaque->setCod($item['cod']);
                $destaque->setImagem($item['imagem']);
                $destaque->setDataExpiracao($item['data_expiracao']);
                $destaque->setStatusExibicao($item['status_exibicao']);
                $destaque->getAdministrador()->setNome($item['nome']);

                $listaDestaques[] = $destaque;
            }

            return $listaDestaques;
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return null;
        }
    }
    
    function exibicaoHome() {
        try {
            $sql = "SELECT d.*, a.nome FROM destaque d JOIN administrador a ON d.administrador_cod = a.cod WHERE status_exibicao = 1 AND data_expiracao >= NOW() ORDER BY data_expiracao DESC";


            $listaRetorno = $this->banco->SelectVariasLinhas($sql);

            $listaDestaques = [];

            foreach ($listaRetorno as $item) {
                $destaque = new Destaque();
                $destaque->setCod($item['cod']);
                $destaque->setImagem($item['imagem']);
                $destaque->setDataExpiracao($item['data_expiracao']);
                $destaque->setStatusExibicao($item['status_exibicao']);
                $destaque->getAdministrador()->setNome($item['nome']);

                $listaDestaques[] = $destaque;
            }

            return $listaDestaques;
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return null;
        }
    }

    function pegarImagem($cod) {
        try {
            $sql = "SELECT imagem FROM destaque WHERE cod = :cod";
            $params = array(
                ":cod" => $cod
            );

            $arrayRet = [];
            $arrayRet = $this->banco->SelectUmaLinha($sql, $params);
            $dest = new Destaque();
            $dest->setImagem($arrayRet['imagem']);
            return $dest;
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return null;
        }
    }

    function excluir($cod) {
        try {
            $sql = "DELETE FROM destaque WHERE cod = :cod";
            $params = array(
                ":cod" => $cod
            );
            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return false;
        }
    }

    function inserir($destaque) {
        try {
            $sql = "INSERT INTO destaque(imagem, data_expiracao, status_exibicao, administrador_cod) VALUES (:imagem, :data_expiracao, :status_exibicao, :administrador_cod)";
            $params = array(
                ":imagem" => $destaque->getImagem(),
                ":data_expiracao" => $destaque->getDataExpiracao(),
                ":status_exibicao" => $destaque->getStatusExibicao(),
                ":administrador_cod" => $destaque->getAdministrador()
            );
            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return false;
        }
    }

    function retirarExibicao($cod) {
        try {
            $sql = "UPDATE destaque SET status_exibicao = 0 WHERE cod = :cod";
            $params = array(
                ":cod" => $cod
            );

            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return false;
        }
    }

    function incluirExibicao($cod) {
        try {
            $sql = "UPDATE destaque SET status_exibicao = 1 WHERE cod = :cod";
            $params = array(
                ":cod" => $cod
            );

            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return false;
        }
    }

}
