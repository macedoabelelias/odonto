<?php

require_once BASE_PATH . "/core/Model.php";

class Caixa extends Model
{

    /* ==========================
       MOVIMENTOS DO DIA
    ========================== */
    public function movimentoDia($data)
    {
        $sql = "
            SELECT 
                'entrada' as tipo,
                descricao,
                valor,
                data_pagamento as data
            FROM contas_receber
            WHERE DATE(data_pagamento) = :data
            AND status = 'pago'

            UNION ALL

            SELECT 
                'saida' as tipo,
                descricao,
                valor,
                data_pagamento as data
            FROM contas_pagar
            WHERE DATE(data_pagamento) = :data
            AND status = 'pago'

            ORDER BY data DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':data', $data);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ==========================
       RESUMO DO DIA
    ========================== */
    public function resumoDia($data)
    {
        $sql = "
            SELECT 

            -- ENTRADAS
            (SELECT SUM(valor) FROM contas_receber
             WHERE DATE(data_pagamento)=:data AND status='pago') as entradas,

            -- SAÍDAS
            (SELECT SUM(valor) FROM contas_pagar
             WHERE DATE(data_pagamento)=:data AND status='pago') as saidas
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':data', $data);
        $stmt->execute();

        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        $entradas = (float)($r['entradas'] ?? 0);
        $saidas = (float)($r['saidas'] ?? 0);

        return [
            'entradas' => $entradas,
            'saidas' => $saidas,
            'saldo' => $entradas - $saidas
        ];
    }
}