<?php

require_once BASE_PATH . "/core/Model.php";

class FilaAtendimento extends Model {

public function listarAguardando(){

$sql = $this->pdo->query("

SELECT f.*, p.nome as paciente

FROM fila_atendimento f
JOIN pacientes p ON p.id = f.paciente_id

WHERE f.status='aguardando'

ORDER BY hora_chegada

");

return $sql->fetchAll(PDO::FETCH_ASSOC);

}

public function chamarPaciente($id){

$sql = $this->pdo->prepare("

UPDATE fila_atendimento
SET status='atendimento',
hora_atendimento=NOW()

WHERE id=?

");

return $sql->execute([$id]);

}

public function finalizar($id){

$sql = $this->pdo->prepare("

UPDATE fila_atendimento
SET status='finalizado',
hora_finalizado=NOW()

WHERE id=?

");

return $sql->execute([$id]);

}

}