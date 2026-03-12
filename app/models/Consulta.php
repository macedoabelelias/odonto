<?php

require_once BASE_PATH . "/core/Model.php";

class Consulta extends Model
{

/* ==========================
   LISTAR CONSULTAS DO DIA
========================== */
public function listarPorData($data,$dentista=null)
{

$sql = "
SELECT consultas.*, 
pacientes.nome AS paciente,
pacientes.foto,
usuarios.nome AS dentista

FROM consultas

LEFT JOIN pacientes
ON pacientes.id = consultas.paciente_id

LEFT JOIN usuarios
ON usuarios.id = consultas.usuario_id

WHERE consultas.data = :data
";

if($dentista){
$sql .= " AND consultas.usuario_id = :dentista ";
}

$sql .= " ORDER BY consultas.hora ";

$stmt = $this->pdo->prepare($sql);

$stmt->bindValue(":data",$data);

if($dentista){
$stmt->bindValue(":dentista",$dentista);
}

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


/* ==========================
   LISTAR SEMANA
========================== */
public function listarSemana($data,$dentista=null)
{

$inicioSemana = date('Y-m-d', strtotime('monday this week', strtotime($data)));
$fimSemana = date('Y-m-d', strtotime('sunday this week', strtotime($data)));

$sql = "
SELECT consultas.*, 
pacientes.nome AS paciente,
pacientes.foto,
usuarios.nome AS dentista

FROM consultas

LEFT JOIN pacientes
ON pacientes.id = consultas.paciente_id

LEFT JOIN usuarios
ON usuarios.id = consultas.usuario_id

WHERE consultas.data BETWEEN :inicio AND :fim
";

if($dentista){
$sql .= " AND consultas.usuario_id = :dentista ";
}

$sql .= " ORDER BY consultas.data, consultas.hora ";

$stmt = $this->pdo->prepare($sql);

$stmt->bindValue(":inicio",$inicioSemana);
$stmt->bindValue(":fim",$fimSemana);

if($dentista){
$stmt->bindValue(":dentista",$dentista);
}

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


/* ==========================
   LISTAR MÊS
========================== */
public function listarMes($data,$dentista=null)
{

$mes = date('m',strtotime($data));
$ano = date('Y',strtotime($data));

$sql = "
SELECT consultas.*, 
pacientes.nome AS paciente,
pacientes.foto,
usuarios.nome AS dentista

FROM consultas

LEFT JOIN pacientes
ON pacientes.id = consultas.paciente_id

LEFT JOIN usuarios
ON usuarios.id = consultas.usuario_id

WHERE MONTH(consultas.data) = :mes
AND YEAR(consultas.data) = :ano
";

if($dentista){
$sql .= " AND consultas.usuario_id = :dentista ";
}

$sql .= " ORDER BY consultas.data, consultas.hora ";

$stmt = $this->pdo->prepare($sql);

$stmt->bindValue(":mes",$mes);
$stmt->bindValue(":ano",$ano);

if($dentista){
$stmt->bindValue(":dentista",$dentista);
}

$stmt->execute();

return $stmt->fetchAll(PDO::FETCH_ASSOC);

}


/* ==========================
   VERIFICAR HORÁRIO OCUPADO
========================== */
public function horarioOcupado($usuario_id,$data,$hora)
{

$sql = $this->pdo->prepare("
SELECT id FROM consultas
WHERE usuario_id = :usuario_id
AND data = :data
AND hora = :hora
");

$sql->bindValue(":usuario_id",$usuario_id);
$sql->bindValue(":data",$data);
$sql->bindValue(":hora",$hora);

$sql->execute();

return $sql->fetch(PDO::FETCH_ASSOC);

}


/* ==========================
   SALVAR CONSULTA
========================== */
public function salvar($dados)
{

$sql = $this->pdo->prepare("
INSERT INTO consultas
(paciente_id,usuario_id,data,hora,duracao,procedimento,observacoes,cor)
VALUES
(:paciente_id,:usuario_id,:data,:hora,:duracao,:procedimento,:observacoes,:cor)
");

$sql->bindValue(":paciente_id",$dados['paciente_id']);
$sql->bindValue(":usuario_id",$dados['usuario_id']);
$sql->bindValue(":data",$dados['data']);
$sql->bindValue(":hora",$dados['hora']);
$sql->bindValue(":duracao",$dados['duracao'] ?? 30);
$sql->bindValue(":procedimento",$dados['procedimento']);
$sql->bindValue(":observacoes",$dados['observacoes']);
$sql->bindValue(":cor",$dados['cor'] ?? "#6ea8fe");

return $sql->execute();

}


/* ==========================
   ATUALIZAR STATUS
========================== */
public function atualizarStatus($id,$status)
{

$sql = $this->pdo->prepare("
UPDATE consultas
SET status = :status
WHERE id = :id
");

$sql->bindValue(":status",$status);
$sql->bindValue(":id",$id);

return $sql->execute();

}


/* ==========================
   BUSCAR CONSULTA
========================== */
public function buscarPorId($id)
{

$sql = $this->pdo->prepare("
SELECT * FROM consultas
WHERE id = :id
");

$sql->bindValue(":id",$id);
$sql->execute();

return $sql->fetch(PDO::FETCH_ASSOC);

}


/* ==========================
   ATUALIZAR CONSULTA
========================== */
public function atualizar($id,$dados)
{

$sql = $this->pdo->prepare("
UPDATE consultas SET
paciente_id=:paciente_id,
usuario_id=:usuario_id,
data=:data,
hora=:hora,
procedimento=:procedimento,
observacoes=:observacoes,
status=:status
WHERE id=:id
");

$sql->bindValue(":paciente_id",$dados['paciente_id']);
$sql->bindValue(":usuario_id",$dados['usuario_id']);
$sql->bindValue(":data",$dados['data']);
$sql->bindValue(":hora",$dados['hora']);
$sql->bindValue(":procedimento",$dados['procedimento']);
$sql->bindValue(":observacoes",$dados['observacoes']);
$sql->bindValue(":status",$dados['status']);
$sql->bindValue(":id",$id);

return $sql->execute();

}


/* ==========================
   ESTATÍSTICAS DA AGENDA
========================== */
public function estatisticasHoje($dentista=null)
{

$data = date('Y-m-d');

$sql = "
SELECT 
COUNT(*) as total,
SUM(CASE WHEN status='atendimento' THEN 1 ELSE 0 END) as atendimento,
SUM(CASE WHEN status='finalizado' THEN 1 ELSE 0 END) as finalizado,
SUM(CASE WHEN status='faltou' THEN 1 ELSE 0 END) as faltou
FROM consultas
WHERE data = :data
";

if($dentista){
$sql .= " AND usuario_id = :dentista ";
}

$stmt = $this->pdo->prepare($sql);

$stmt->bindValue(":data",$data);

if($dentista){
$stmt->bindValue(":dentista",$dentista);
}

$stmt->execute();

return $stmt->fetch(PDO::FETCH_ASSOC);

}

public function index()
{

require_once BASE_PATH."/app/models/Consulta.php";
require_once BASE_PATH."/app/models/Paciente.php";
require_once BASE_PATH."/app/models/Financeiro.php";

$consultaModel = new Consulta();
$pacienteModel = new Paciente();
$financeiroModel = new Financeiro();

$dataHoje = date('Y-m-d');

/* CONSULTAS HOJE */

$consultasHoje = $consultaModel->listarPorData($dataHoje);

/* PACIENTES ATENDIDOS */

$atendidosHoje = $consultaModel->contarAtendidosHoje();

/* FATURAMENTO HOJE */

$faturamentoHoje = $financeiroModel->faturamentoHoje();

/* PRÓXIMAS CONSULTAS */

$proximas = $consultaModel->proximasConsultas();

/* ANIVERSARIANTES */

$aniversariantes = $pacienteModel->aniversariantesHoje();

$this->view("dashboard/index",[

"consultasHoje"=>$consultasHoje,
"atendidosHoje"=>$atendidosHoje,
"faturamentoHoje"=>$faturamentoHoje,
"proximas"=>$proximas,
"aniversariantes"=>$aniversariantes

]);

}

public function proximasConsultas()
{

$sql = $this->pdo->query("
SELECT consultas.*, pacientes.nome as paciente
FROM consultas
LEFT JOIN pacientes ON pacientes.id = consultas.paciente_id
WHERE data >= CURDATE()
ORDER BY data, hora
LIMIT 5
");

return $sql->fetchAll(PDO::FETCH_ASSOC);

}

}