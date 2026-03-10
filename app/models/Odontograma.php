<?php

require_once BASE_PATH . "/core/Database.php";

class Odontograma {

private $pdo;

public function __construct(){
$this->pdo = Database::getConnection();
}

/* SALVAR */

public function salvar($dados){

$sql = $this->pdo->prepare("
INSERT INTO odontograma_registros 
(paciente_id,dente,face,status)
VALUES (:paciente_id,:dente,:face,:status)
");

$sql->bindValue(":paciente_id",$dados["paciente_id"]);
$sql->bindValue(":dente",$dados["dente"]);
$sql->bindValue(":face",$dados["face"]);
$sql->bindValue(":status",$dados["status"]);

$sql->execute();

}


/* BUSCAR ODONTOGRAMA */

public function buscarPorPaciente($paciente_id){

$sql = $this->pdo->prepare("
SELECT * FROM odontograma_registros
WHERE paciente_id = :paciente_id
");

$sql->bindValue(":paciente_id",$paciente_id);
$sql->execute();

return $sql->fetchAll(PDO::FETCH_ASSOC);

}

}