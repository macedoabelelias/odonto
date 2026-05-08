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

        $sql->bindValue(":data", $data);
        $sql->execute();

        return (float)($sql->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }


    /* ==========================
       RECEBIDO HOJE
    ========================== */
    public function recebidoHoje($data = null)
    {
        $data = $data ?? date('Y-m-d');

        $sql = $this->pdo->prepare("
            SELECT SUM(valor) as total
            FROM contas_receber
            WHERE DATE(data_pagamento) = :data
            AND status = 'pago'
        ");

        $sql->bindValue(":data", $data);
        $sql->execute();

        return (float)($sql->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
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

        return (float)($sql->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }


    /* ==========================
       CONTAS VENCIDAS
    ========================== */
    public function contasVencidas()
    {
        $sql = $this->pdo->query("
            SELECT SUM(valor) as total
            FROM contas_receber
            WHERE status = 'pendente'
            AND data_vencimento < CURDATE()
        ");

        return (float)($sql->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }


    /* ==========================
       CONTAS A PAGAR HOJE
    ========================== */
    public function contasPagarHoje($data)
    {
        $sql = $this->pdo->prepare("
            SELECT SUM(valor) as total
            FROM contas_pagar 
            WHERE data_vencimento = :data 
            AND status = 'pendente'
        ");

        $sql->bindValue(':data', $data);
        $sql->execute();

        return (float)($sql->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }


    /* ==========================
       PAGO HOJE
    ========================== */
    public function pagoHoje($data)
    {
        $sql = $this->pdo->prepare("
            SELECT SUM(valor) as total
            FROM contas_pagar 
            WHERE DATE(data_pagamento) = :data 
            AND status = 'pago'
        ");

        $sql->bindValue(':data', $data);
        $sql->execute();

        return (float)($sql->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }


    /* ==========================
       TOTAL A PAGAR
    ========================== */
    public function totalAPagar()
    {
        $sql = $this->pdo->query("
            SELECT SUM(valor) as total
            FROM contas_pagar 
            WHERE status = 'pendente'
        ");

        return (float)($sql->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }


    /* ==========================
       PRODUÇÃO MENSAL (RECEITA)
    ========================== */
    public function producaoMensal()
    {
        $sql = "
            SELECT 
                MONTH(data_pagamento) as mes,
                SUM(valor) as total
            FROM contas_receber
            WHERE status = 'pago'
            AND YEAR(data_pagamento) = YEAR(CURDATE())
            GROUP BY MONTH(data_pagamento)
        ";

        $result = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $dados = array_fill(1, 12, 0);

        foreach($result as $r){
            $dados[(int)$r['mes']] = (float)$r['total'];
        }

        return array_values($dados);
    }


    /* ==========================
       RECEITA VS DESPESA
    ========================== */
    public function receitaVsDespesa()
{
    $receitas = $this->pdo->query("
        SELECT MONTH(data_vencimento) as mes, SUM(valor) as total
        FROM contas_receber
        GROUP BY MONTH(data_vencimento)
    ")->fetchAll(PDO::FETCH_ASSOC);

    $despesas = $this->pdo->query("
        SELECT MONTH(data_vencimento) as mes, SUM(valor) as total
        FROM contas_pagar
        GROUP BY MONTH(data_vencimento)
    ")->fetchAll(PDO::FETCH_ASSOC);

    $r = array_fill(1, 12, 0);
    $d = array_fill(1, 12, 0);

    foreach($receitas as $row){
        $r[(int)$row['mes']] = (float)$row['total'];
    }

    foreach($despesas as $row){
        $d[(int)$row['mes']] = (float)$row['total'];
    }

    return [
        'receitas' => array_values($r),
        'despesas' => array_values($d)
    ];
}

    /* ==========================
       CONTAS A PAGAR VENCIDAS
    ========================== */
    public function contasPagarVencidas()
    {
        $sql = $this->pdo->query("
            SELECT SUM(valor) as total
            FROM contas_pagar
            WHERE status = 'pendente'
            AND data_vencimento < CURDATE()
        ");

        return (float)($sql->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
    }

    public function lucroMensal()
{
    $dados = $this->receitaVsDespesa();

    $lucro = [];

    for($i = 0; $i < 12; $i++){
        $lucro[] = $dados['receitas'][$i] - $dados['despesas'][$i];
    }

    return $lucro;
}

public function registrar($dados)
{
    // ==========================
    // GARANTE O ID
    // ==========================
    $id = is_array($dados) ? $dados['id'] : $dados;

    // ==========================
    // BUSCAR DADOS DA CONTA
    // ==========================
    $sql = $this->pdo->prepare("
        SELECT valor, profissional_id, tipo
        FROM contas_receber 
        WHERE id = :id
    ");
    $sql->bindValue(":id", $id);
    $sql->execute();

    $conta = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$conta) {
        return false;
    }

    // ==========================
    // MARCAR COMO PAGO
    // ==========================
    $update = $this->pdo->prepare("
        UPDATE contas_receber SET
            status = 'pago',
            data_pagamento = NOW()
        WHERE id = :id
    ");
    $update->bindValue(":id", $id);
    $update->execute();

    // ==========================
    // DENTISTA
    // ==========================
    $profissional_id = $conta['profissional_id'] ?? null;

    if (!$profissional_id) {
        return $conta;
    }

    // ==========================
    // EVITA DUPLICAÇÃO
    // ==========================
    $check = $this->pdo->prepare("
        SELECT id FROM comissoes 
        WHERE conta_receber_id = :id
    ");
    $check->bindValue(":id", $id);
    $check->execute();

    if ($check->fetch()) {
        return $conta;
    }

    // ==========================
    // DEFINIR % POR TIPO
    // ==========================
    $tipo = $conta['tipo'] ?? 'particular';

    if ($tipo == 'convenio') {
        $percentual = 18;
    } else {
        $percentual = 25;
    }

    // ==========================
    // CALCULAR COMISSÃO
    // ==========================
    $valor = (float) $conta['valor'];
    $valor_comissao = ($valor * $percentual) / 100;

    // ==========================
    // SALVAR COMISSÃO
    // ==========================
    $this->salvarComissao([
        "conta_receber_id" => $id,
        "profissional" => $profissional_id,
        "valor_procedimento" => $valor,
        "percentual" => $percentual,
        "valor_comissao" => $valor_comissao,
        "data" => date("Y-m-d")
    ]);

    return $conta;
}


public function salvarComissao($dados)
{
    $sql = $this->pdo->prepare("
        INSERT INTO comissoes (
            conta_receber_id,
            profissional,
            valor_procedimento,
            percentual,
            valor_comissao,
            data,
            created_at
        ) VALUES (
            :conta_receber_id,
            :profissional,
            :valor_procedimento,
            :percentual,
            :valor_comissao,
            :data,
            NOW()
        )
    ");

    $sql->bindValue(":conta_receber_id", $dados['conta_receber_id']);
    $sql->bindValue(":profissional", $dados['profissional']);
    $sql->bindValue(":valor_procedimento", $dados['valor_procedimento']);
    $sql->bindValue(":percentual", $dados['percentual']);
    $sql->bindValue(":valor_comissao", $dados['valor_comissao']);
    $sql->bindValue(":data", $dados['data']);

    return $sql->execute();
}
}