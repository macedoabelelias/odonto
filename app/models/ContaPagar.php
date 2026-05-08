<?php

require_once BASE_PATH . "/core/Model.php";

class ContaPagar extends Model
{

    public function listar($filtro = null)
    {
        $sql = "SELECT * FROM contas_pagar WHERE 1=1";

        if ($filtro == 'pendente') {
            $sql .= " AND status = 'pendente'";
        }
        elseif ($filtro == 'pago') {
            $sql .= " AND status = 'pago'";
        }
        elseif ($filtro == 'vencidas') {
            $sql .= " AND status = 'pendente'
                      AND data_vencimento < CURDATE()";
        }

        $sql .= " ORDER BY data_vencimento ASC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function criar($dados)
    {
        $sql = "INSERT INTO contas_pagar 
                (descricao, valor, data_vencimento, status)
                VALUES (:descricao, :valor, :data_vencimento, 'pendente')";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':descricao', $dados['descricao']);
        $stmt->bindValue(':valor', $dados['valor']);
        $stmt->bindValue(':data_vencimento', $dados['data_vencimento']);

        return $stmt->execute();
    }


    public function pagar($id, $forma)
    {
        $sql = "UPDATE contas_pagar 
                SET status='pago',
                    forma_pagamento=:forma,
                    data_pagamento=NOW()
                WHERE id=:id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':forma', $forma);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }


    public function resumoFinanceiro()
    {
        $sql = "
            SELECT 
                SUM(CASE 
                    WHEN status='pago' AND DATE(data_pagamento)=CURDATE() 
                    THEN valor ELSE 0 END) as hoje,

                SUM(CASE 
                    WHEN status='pendente' 
                    THEN valor ELSE 0 END) as pendente,

                SUM(CASE 
                    WHEN status='pendente' 
                    AND data_vencimento < CURDATE()
                    THEN valor ELSE 0 END) as vencidas

            FROM contas_pagar
        ";

        $result = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

        return [
            'hoje' => (float)($result['hoje'] ?? 0),
            'pendente' => (float)($result['pendente'] ?? 0),
            'vencidas' => (float)($result['vencidas'] ?? 0)
        ];
    }


    public function excluir($id)
    {
        $sql = "DELETE FROM contas_pagar WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

}