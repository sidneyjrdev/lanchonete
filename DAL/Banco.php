<?php

class Banco {

    private static $conn;

    public static function getConnection() {
        try {
            if(self::$conn == null){
                self::$conn = new PDO("mysql:host=localhost; dbname=lanchonete", "root", "");
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$conn;
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            return false;
        }
    }

    function SelectUmaLinha($sql, $params = null) {
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            die();
            return null;
        }
    }

    function SelectVariasLinhas($sql, $params = null) {
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            die();
            return null;
        }
    }

    function NonQuery($sql, $params = null) {
        try {
            $stmt = $this->getConnection()->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            echo 'erro: ' . $e->getMessage() . ' na linha: ' . $e->getLine();
            die();
            return false;
        }
    }

}
