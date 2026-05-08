<?php

require_once BASE_PATH . "/core/Model.php";

class EvolucaoClinica extends Model
{
    // 🔹 SALVAR EVOLUÇÃO
    public function salvar($dados)
    {
        $sql = $this->pdo->prepare("
            INSERT INTO evolucoes_clinicas 
            (paciente_id, procedimento_id, status, observacao, data)
            VALUES (?, ?, ?, ?, NOW())
        ");

        return $sql->execute([
            $dados['paciente_id'],
            $dados['procedimento_id'],
            $dados['status'],
            $dados['observacao'] ?? null
        ]);
    }

    // 🔹 LISTAR EVOLUÇÕES DO PACIENTE
public function listarPorPaciente($paciente_id)
{
    $sql = $this->pdo->prepare("
        SELECT 
            e.*,
            p.nome AS procedimento_nome,
            (
                SELECT oi.valor
                FROM orcamentos o
                INNER JOIN orcamentos_itens oi 
                    ON oi.orcamento_id = o.id
                WHERE 
                    o.paciente_id = e.paciente_id
                    AND oi.procedimento = e.observacao
                ORDER BY o.id DESC
                LIMIT 1
            ) AS valor
        FROM evolucoes_clinicas e

        LEFT JOIN procedimentos p 
            ON p.id = e.procedimento_id

        WHERE e.paciente_id = ?
        ORDER BY e.data DESC
    ");

    $sql->execute([$paciente_id]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

    // 🔹 ATUALIZAR STATUS
    public function atualizarStatus($id, $status)
    {
        $sql = $this->pdo->prepare("
            UPDATE evolucoes_clinicas 
            SET status = ?
            WHERE id = ?
        ");

        return $sql->execute([$status, $id]);
    }
}