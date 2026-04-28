<?php

require_once BASE_PATH . "/core/Model.php";

class ProntuarioProcedimento extends Model
{
    public function salvar($dados)
{
    $sql = "INSERT INTO prontuario_procedimentos 
    (paciente_id, dente, procedimento_id, data, observacao, status)
    VALUES (:paciente_id, :dente, :procedimento_id, :data, :observacao, :status)";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        ':paciente_id' => $dados['paciente_id'],
        ':dente' => $dados['dente'],
        ':procedimento_id' => $dados['procedimento_id'],
        ':data' => date('Y-m-d H:i:s'),
        ':observacao' => $dados['observacao'] ?? '',
        ':status' => $dados['status'] ?? 'planejado'
    ]);
}

    public function listarPorPaciente($paciente_id)
    {
        $sql = "SELECT pp.*, p.nome as procedimento
                FROM prontuario_procedimentos pp
                LEFT JOIN procedimentos p ON p.id = pp.procedimento_id
                WHERE pp.paciente_id = :id
                ORDER BY pp.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $paciente_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}