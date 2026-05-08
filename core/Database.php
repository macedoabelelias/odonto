<?php

class Database {

    private static $instance = null;

    public static function getConnection() {

        if (self::$instance === null) {

            $host = "localhost";
            $db   = "odonto";
            $user = "root";
            $pass = "";

            try {
                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8",
                    $user,
                    $pass
                );

                self::$instance->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

            } catch (PDOException $e) {
                die("Erro: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}