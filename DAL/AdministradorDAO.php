<?php

require_once "Banco.php";

class AdministradorDAO {

    private $banco;
    private $res;

    public function __construct() {
        $this->banco = new Banco();
    }

    function pegarAdmLogin($email, $senha) {
        try {
            $sql = "SELECT cod, nome FROM administrador WHERE email=:email AND senha=:senha";
            $params = array(
                ":email" => $email,
                ":senha" => $senha);

            $res = $this->banco->SelectUmaLinha($sql, $params);

            if ($res != null) {
                $adm = new Administrador();
                $adm->setCod($res['cod']);
                $adm->setNome($res['nome']);
                return $adm;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();

            return null;
        }
    }

    function cadastrarAdm($adm) {
        try {

            $sql = "INSERT INTO administrador(nome, email, senha, foto) VALUES(:nome, :email, :senha, :foto)";
            $params = array(
                ":nome" => $adm->getNome(),
                ":email" => $adm->getEmail(),
                ":senha" => md5($adm->getSenha()),
                ":foto" => $adm->getFoto()
            );

            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

    public function pegarListaEmails() {
        try {
            $sql = "SELECT email from administrador";
            $listaEmails = [];
            $listaEmails = $this->banco->SelectVariasLinhas($sql);
            return $listaEmails;
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

    function pegarAdmCod($cod) {
        try {
            $sql = "SELECT * from administrador WHERE cod = :cod";
            $params = array(
                ":cod" => $cod
            );

            $arrayAdm = $this->banco->SelectUmaLinha($sql, $params);
            if ($arrayAdm != null) {
                $adm = new Administrador();
                $adm->setCod($arrayAdm['cod']);
                $adm->setEmail($arrayAdm['email']);
                $adm->setFoto($arrayAdm['foto']);
                $adm->setNome($arrayAdm['nome']);
                $adm->setSenha($arrayAdm['senha']);

                return $adm;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

    public function editarAdm($adm, $atualizaImg) {
        try {
            if ($atualizaImg) {
                $sql = "UPDATE administrador SET nome = :nome, email = :email, foto = :foto WHERE cod = :cod";
                $params = array(
                    ":nome" => $adm->getNome(),
                    ":email" => $adm->getEmail(),
                    ":foto" => $adm->getFoto(),
                    ":cod" => $adm->getCod()
                );
            } else {
                $sql = "UPDATE administrador SET nome = :nome, email = :email WHERE cod = :cod";
                $params = array(
                    ":nome" => $adm->getNome(),
                    ":email" => $adm->getEmail(),
                    ":cod" => $adm->getCod()
                );
            }

            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

    public function excluirAdm($cod) {
        try {
            $sql = "DELETE FROM administrador WHERE cod = :cod";
            $params = array(
                ":cod" => $cod
            );

            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

    public function mudarSenha($cod, $senha) {
        try {
            $sql = "UPDATE administrador SET senha = :senha WHERE cod = :cod";

            $params = array(
                ":senha" => md5($senha),
                ":cod" => $cod
            );
            return $this->banco->NonQuery($sql, $params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

}
