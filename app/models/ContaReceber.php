<?php

require_once BASE_PATH . "/core/Model.php";

class ContaReceber extends Model
{

    /* ==========================
       LISTAR
    ========================== */
    public function listar($filtro = null, $busca = null)
    {
        $sql = "
            SELECT 
                cr.id,
                cr.paciente_id,
                cr.descricao,
                cr.valor,
                cr.data_vencimento,
                cr.status,
                cr.profissional_id,
                cr.convenio_id,
                p.nome AS paciente,
                conv.nome AS convenio_nome,
                conv.percentual AS convenio_percentual
            FROM contas_receber cr
            LEFT JOIN pacientes p ON p.id = cr.paciente_id
            LEFT JOIN convenios conv ON conv.id = cr.convenio_id
            WHERE 1=1
        ";

        // FILTROS
        if ($filtro == 'pendente') {
            $sql .= " AND cr.status = 'pendente'";
        } elseif ($filtro == 'pago') {
            $sql .= " AND cr.status = 'pago'";
        } elseif ($filtro == 'vencidas') {
            $sql .= " AND cr.status = 'pendente'
                      AND cr.data_vencimento < CURDATE()";
        }

        // BUSCA
        if (!empty($busca)) {
            $sql .= " AND p.nome LIKE :busca";
        }

        $sql .= " ORDER BY cr.data_vencimento DESC";

        $stmt = $this->pdo->prepare($sql);

        if (!empty($busca)) {
            $stmt->bindValue(':busca', "%".$busca."%");
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ==========================
       CRIAR
    ========================== */
    public function criar($dados)
    {
        $sql = "INSERT INTO contas_receber 
        (
            paciente_id,
            descricao,
            valor,
            data_vencimento,
            status,
            profissional_id,
            convenio_id
        )
        VALUES
        (
            :paciente_id,
            :descricao,
            :valor,
            :data_vencimento,
            :status,
            :profissional_id,
            :convenio_id
        )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':paciente_id'     => $dados['paciente_id'],
            ':descricao'       => $dados['descricao'],
            ':valor'           => str_replace(',', '.', $dados['valor']),
            ':data_vencimento' => $dados['data_vencimento'],
            ':status'          => 'pendente',
            ':profissional_id' => $dados['profissional_id'],
            ':convenio_id'     => $dados['convenio_id'] ?? null
        ]);
    }


    /* ==========================
       MARCAR COMO PAGO
    ========================== */
    public function marcarComoPago($id, $forma)
    {
        // buscar conta
        $sql = "SELECT * FROM contas_receber WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        $conta = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$conta) return false;

        // atualizar
        $sql = "UPDATE contas_receber 
                SET status='pago',
                    forma_pagamento=:forma,
                    data_pagamento=NOW()
                WHERE id=:id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":forma", $forma);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        // evitar duplicidade
        $sql = "SELECT id FROM financeiro WHERE conta_id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        if (!$stmt->fetch()) {

            $sql = "INSERT INTO financeiro 
                    (tipo, descricao, valor, data, conta_id, forma_pagamento)
                    VALUES 
                    ('entrada', :descricao, :valor, CURDATE(), :conta_id, :forma)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":descricao", $conta['descricao']);
            $stmt->bindValue(":valor", $conta['valor']);
            $stmt->bindValue(":conta_id", $id);
            $stmt->bindValue(":forma", $forma);
            $stmt->execute();
        }

        // retorna com paciente
        $sql = "
            SELECT cr.*, p.nome AS paciente
            FROM contas_receber cr
            LEFT JOIN pacientes p ON p.id = cr.paciente_id
            WHERE cr.id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /* ==========================
       RESUMO
    ========================== */
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
                    WHEN status='pago' 
                    AND MONTH(data_pagamento)=MONTH(CURDATE())
                    THEN valor ELSE 0 END) as mes,

                SUM(CASE 
                    WHEN status='pendente' 
                    AND data_vencimento < CURDATE()
                    THEN valor ELSE 0 END) as vencidas

            FROM contas_receber
        ";

        $r = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

        return [
            'hoje' => (float)($r['hoje'] ?? 0),
            'pendente' => (float)($r['pendente'] ?? 0),
            'mes' => (float)($r['mes'] ?? 0),
            'vencidas' => (float)($r['vencidas'] ?? 0)
        ];
    }


    /* ==========================
       EXCLUIR
    ========================== */
    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM contas_receber WHERE id = :id");
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }


    /* ==========================
       BUSCAR
    ========================== */
    public function buscar($id)
    {
        $sql = "
            SELECT 
                cr.*,
                p.nome AS paciente
            FROM contas_receber cr
            LEFT JOIN pacientes p ON p.id = cr.paciente_id
            WHERE cr.id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}