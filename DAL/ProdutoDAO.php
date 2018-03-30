<?php

require_once 'Banco.php';

if (isset($_SESSION['cod'])) {
    require_once "../model/Produto.php";
} else {
    require_once "model/Produto.php";
}

class ProdutoDAO {

    private $banco;

    public function __construct() {
        $this->banco = new Banco();
    }

    public function pegarQtdTotal($tipo, $termo) {
        try {

            $sql = "SELECT COUNT(cod) AS qtd_total FROM produto WHERE tipo = :tipo AND nome LIKE :termo";
            if ($tipo == 0) {
                $tipo = '%';
                $sql = "SELECT COUNT(cod) AS qtd_total FROM produto WHERE tipo LIKE :tipo AND nome LIKE :termo";
            }

            $termo = '%' . $termo . '%';
            $params = array(
                ":tipo" => $tipo,
                ":termo" => $termo
            );

            $arrayRetornado = $this->banco->SelectUmaLinha($sql, $params);
            return $arrayRetornado['qtd_total'];
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return 0;
        }
    }

    public function pegarFiltro($tipo, $ordem, $inicio, $qtdExibida, $termo) {


        try {
            if ($ordem == "nome") {
                $sql = "SELECT p.*, a.nome AS nome_adm FROM produto p JOIN administrador a ON p.administrador_cod = a.cod WHERE p.tipo = :tipo && p.nome LIKE :termo ORDER BY p.nome ASC LIMIT " . $qtdExibida . " OFFSET " . $inicio;
            } else if ($ordem == "data_mod") {
                $sql = "SELECT p.*, a.nome AS nome_adm FROM produto p JOIN administrador a ON p.administrador_cod = a.cod WHERE p.tipo = :tipo && p.nome LIKE :termo ORDER BY p.data_ultima_modific DESC LIMIT " . $qtdExibida . " OFFSET " . $inicio;
            }

            if ($tipo == 0) {
                $tipo = '%';
                if ($ordem == "nome") {
                    $sql = "SELECT p.*, a.nome AS nome_adm FROM produto p JOIN administrador a ON p.administrador_cod = a.cod WHERE p.tipo LIKE :tipo && p.nome LIKE :termo ORDER BY p.nome ASC LIMIT " . $qtdExibida . " OFFSET " . $inicio;
                } else if ($ordem == "data_mod") {
                    $sql = "SELECT p.*, a.nome AS nome_adm FROM produto p JOIN administrador a ON p.administrador_cod = a.cod WHERE p.tipo LIKE :tipo && p.nome LIKE :termo ORDER BY p.data_ultima_modific DESC LIMIT " . $qtdExibida . " OFFSET " . $inicio;
                }
            }

            $termo = '%' . $termo . '%';

            $params = array(
                ":tipo" => $tipo,
                ":termo" => $termo
            );

            $listaRetornar = [];


            $listaProdutos = $this->banco->SelectVariasLinhas($sql, $params);

            foreach ($listaProdutos as $item) {
                $prod = new Produto();
                $prod->setNome($item['nome']);
                $prod->setCod($item['cod']);
                $prod->setTipo($item['tipo']);
                $prod->setDescricao($item['descricao']);
                $prod->setPreco($item['preco']);
                $prod->setDataUltimaModific($item['data_ultima_modific']);
                $prod->setImagem($item['imagem']);
                $prod->setSlug($item['slug']);
                $prod->getAdministrador()->setNome($item['nome_adm']);
                $listaRetornar[] = $prod;
            }

            return $listaRetornar;
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return null;
        }
    }

    public function pegarTipo($tipo) {


        try {
            $sql = "SELECT nome, preco FROM produto WHERE tipo = :tipo";

            $params = array(
                ":tipo" => $tipo
            );

            $listaRetornar = [];

            $listaProdutos = $this->banco->SelectVariasLinhas($sql, $params);

            foreach ($listaProdutos as $item) {
                $prod = new Produto();
                $prod->setNome($item['nome']);
                $prod->setPreco($item['preco']);

                $listaRetornar[] = $prod;
            }

            return $listaRetornar;
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return null;
        }
    }

    public function excluir($cod) {
        try {
            $sql = "DELETE FROM produto WHERE cod = :cod";

            $params = array(
                ":cod" => $cod
            );

            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return null;
        }
    }

    public function pegarUm($cod) {
        try {
            $sql = "SELECT p.*, a.nome as nome_adm FROM produto p JOIN administrador a ON p.administrador_cod = a.cod WHERE p.cod = :cod";

            $params = array(
                ":cod" => $cod
            );

            $arrayProd = $this->banco->SelectUmaLinha($sql, $params);

            if ($arrayProd != null) {

                $prod = new Produto();
                $prod->setNome($arrayProd['nome']);
                $prod->setCod($arrayProd['cod']);
                $prod->setTipo($arrayProd['tipo']);
                $prod->setDescricao($arrayProd['descricao']);
                $prod->setPreco($arrayProd['preco']);
                $prod->setDataUltimaModific($arrayProd['data_ultima_modific']);
                $prod->setImagem($arrayProd['imagem']);
                $prod->setSlug($arrayProd['slug']);
                $prod->getAdministrador()->setNome($arrayProd['nome_adm']);


                return $prod;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return null;
        }
    }

    public function editar(Produto $prod, bool $atualizaImg) {
        try {

            if (!$atualizaImg) {
                $sql = "UPDATE produto SET data_ultima_modific = :data, nome = :nome, tipo = :tipo, descricao = :descricao, preco = :preco WHERE cod = :cod";

                $params = array(
                    ":data" => $prod->getDataUltimaModific(),
                    ":nome" => $prod->getNome(),
                    ":tipo" => $prod->getTipo(),
                    ":descricao" => $prod->getDescricao(),
                    ":preco" => $prod->getPreco(),
                    ":cod" => $prod->getCod()
                );
            } else {
                $sql = "UPDATE produto SET data_ultima_modific = :data, nome = :nome, tipo = :tipo, descricao = :descricao, preco = :preco, imagem = :imagem WHERE cod = :cod";

                $params = array(
                    ":data" => $prod->getDataUltimaModific(),
                    ":nome" => $prod->getNome(),
                    ":tipo" => $prod->getTipo(),
                    ":descricao" => $prod->getDescricao(),
                    ":preco" => $prod->getPreco(),
                    ":imagem" => $prod->getImagem(),
                    ":cod" => $prod->getCod()
                );
            }
            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

    public function inserir($prod) {
        try {
            $sql = "INSERT INTO produto(nome, tipo, descricao, preco, slug, imagem, administrador_cod) VALUES (:nome, :tipo, :descricao, :preco, :slug, :imagem, :administrador_cod)";

            $params = array(
                ":nome" => $prod->getNome(),
                ":tipo" => $prod->getTipo(),
                ":descricao" => $prod->getDescricao(),
                ":preco" => $prod->getPreco(),
                ":imagem" => $prod->getImagem(),
                ":slug" => $prod->getSlug(),
                ":administrador_cod" => $prod->getAdministrador()
            );

            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

}
