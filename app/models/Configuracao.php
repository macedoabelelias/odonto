<?php

class Configuracao {

private $pdo;

public function __construct(){

require BASE_PATH."/config/conexao.php";
$this->pdo = $pdo;

}

public function get(){

$sql = $this->pdo->query("SELECT * FROM configuracoes LIMIT 1");
return $sql->fetch(PDO::FETCH_ASSOC);

}

public function salvar($nome,$logo){

$sql = $this->pdo->prepare("

UPDATE configuracoes SET

nome_clinica = :nome,
logo = :logo

WHERE id = 1

");

$sql->bindValue(":nome",$nome);
$sql->bindValue(":logo",$logo);

$sql->execute();

}

}