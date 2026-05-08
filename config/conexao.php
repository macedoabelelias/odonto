<?php

$host = "localhost";
$db   = "odonto";
$user = "root";
$pass = "";
$charset = "utf8";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_PERSISTENT         => true // 🔥 evita muitas conexões
];

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=$charset",
        $user,
        $pass,
        $options
    );

} catch (PDOException $e) {

    die("Erro na conexão: " . $e->getMessage());

}