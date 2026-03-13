<?php

require_once BASE_PATH . "/core/Model.php";

class Financeiro extends Model
{

/* ==========================
   CONTAS A RECEBER HOJE
========================== */
public function contasReceberHoje($data)
{

$sql = $this->pdo->prepare("
SELECT SUM(valor) as total
FROM contas_receber
WHERE data_vencimento = :data
AND status = 'pendente'
");

$sql->bindValue(":data",$data);
$sql->execute();

$result = $sql->fetch(PDO::FETCH_ASSOC);

return $result['total'] ?? 0;

}


/* ==========================
   RECEBIDO HOJE
========================== */
public function recebidoHoje($data)
{

$sql = $this->pdo->prepare("
SELECT SUM(valor) as total
FROM contas_receber
WHERE data_pagamento = :data
AND status = 'pago'
");

$sql->bindValue(":data",$data);
$sql->execute();

$result = $sql->fetch(PDO::FETCH_ASSOC);

return $result['total'] ?? 0;

}


/* ==========================
   TOTAL EM ABERTO
========================== */
public function totalEmAberto()
{

$sql = $this->pdo->query("
SELECT SUM(valor) as total
FROM contas_receber
WHERE status = 'pendente'
");

$result = $sql->fetch(PDO::FETCH_ASSOC);

return $result['total'] ?? 0;

}


/* ==========================
   FATURAMENTO HOJE
========================== */
public function faturamentoHoje()
{

$sql = $this->pdo->query("
SELECT SUM(valor) as total
FROM contas_receber
WHERE data_pagamento = CURDATE()
AND status = 'pago'
");

$result = $sql->fetch(PDO::FETCH_ASSOC);

return $result['total'] ?? 0;

}

}