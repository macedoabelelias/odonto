<?php

require_once BASE_PATH . "/core/Model.php";

class Consulta extends Model
{

    /* ==========================
       LISTAR POR DATA
    ========================== */
    public function listarPorData($data, $dentista = null)
    {
        $sql = "
        SELECT consultas.*, 
        pacientes.nome AS paciente,
        usuarios.nome AS dentista
        FROM consultas
        LEFT JOIN pacientes ON pacientes.id = consultas.paciente_id
        LEFT JOIN usuarios ON usuarios.id = consultas.usuario_id
        WHERE consultas.data = :data
        ";

        if ($dentista) {
            $sql .= " AND consultas.usuario_id = :dentista ";
        }

        $sql .= " ORDER BY consultas.hora";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":data", $data);

        if ($dentista) {
            $stmt->bindValue(":dentista", $dentista);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ==========================
       ESTATÍSTICAS HOJE
    ========================== */
    public function estatisticasHoje($dentista = null)
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

        if ($dentista) {
            $sql .= " AND usuario_id = :dentista ";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":data", $data);

        if ($dentista) {
            $stmt->bindValue(":dentista", $dentista);
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

//  =================LISTAR SEMANA =============================
    public function listarSemana($data, $dentista = null)
{
    $inicio = date('Y-m-d', strtotime('monday this week', strtotime($data)));
    $fim = date('Y-m-d', strtotime('sunday this week', strtotime($data)));

    $sql = "
    SELECT consultas.*, 
           pacientes.nome AS paciente,
           usuarios.nome AS dentista
    FROM consultas
    LEFT JOIN pacientes ON pacientes.id = consultas.paciente_id
    LEFT JOIN usuarios ON usuarios.id = consultas.usuario_id
    WHERE consultas.data BETWEEN :inicio AND :fim
    ";

    if ($dentista) {
        $sql .= " AND consultas.usuario_id = :dentista ";
    }

    $sql .= " ORDER BY consultas.data, consultas.hora";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":inicio", $inicio);
    $stmt->bindValue(":fim", $fim);

    if ($dentista) {
        $stmt->bindValue(":dentista", $dentista);
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// =============LISTAR MES ==============
public function listarMes($data, $dentista = null)
{
    $inicio = date('Y-m-01', strtotime($data));
    $fim = date('Y-m-t', strtotime($data));

    $sql = "
    SELECT consultas.*, 
           pacientes.nome AS paciente,
           usuarios.nome AS dentista
    FROM consultas
    LEFT JOIN pacientes ON pacientes.id = consultas.paciente_id
    LEFT JOIN usuarios ON usuarios.id = consultas.usuario_id
    WHERE consultas.data BETWEEN :inicio AND :fim
    ";

    if ($dentista) {
        $sql .= " AND consultas.usuario_id = :dentista ";
    }

    $sql .= " ORDER BY consultas.data, consultas.hora";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":inicio", $inicio);
    $stmt->bindValue(":fim", $fim);

    if ($dentista) {
        $stmt->bindValue(":dentista", $dentista);
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// ====================== HORARIO OCUPADO============
public function horarioOcupado($usuario_id, $data, $hora)
{
    $sql = "
        SELECT id 
        FROM consultas 
        WHERE usuario_id = :usuario
        AND data = :data
        AND hora = :hora
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":usuario", $usuario_id);
    $stmt->bindValue(":data", $data);
    $stmt->bindValue(":hora", $hora);

    $stmt->execute();

    return $stmt->rowCount() > 0;
}

// =================== SALVAR=====================

public function salvar($dados)
{
    $sql = "
        INSERT INTO consultas 
        (paciente_id, usuario_id, data, hora, procedimento, observacoes, status)
        VALUES
        (:paciente_id, :usuario_id, :data, :hora, :procedimento, :observacoes, 'agendado')
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(":paciente_id", $dados['paciente_id']);
    $stmt->bindValue(":usuario_id", $dados['usuario_id']);
    $stmt->bindValue(":data", $dados['data']);
    $stmt->bindValue(":hora", $dados['hora']);
    $stmt->bindValue(":procedimento", $dados['procedimento']);
    $stmt->bindValue(":observacoes", $dados['observacoes']);

    return $stmt->execute();
}

// =================ULTIMO ID ===============
public function ultimoId()
{
    return $this->pdo->lastInsertId();
}

// ============ ATUALIZAR STATUS ================

public function atualizarStatus($id, $status)
{
    $sql = "UPDATE consultas SET status = :status WHERE id = :id";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":status", $status);
    $stmt->bindValue(":id", $id);

    return $stmt->execute();
}

// ===============BUSCAR POR ID ==============

public function buscarPorId($id)
{
    $sql = "
        SELECT consultas.*, 
               pacientes.nome AS paciente,
               usuarios.nome AS dentista
        FROM consultas
        LEFT JOIN pacientes ON pacientes.id = consultas.paciente_id
        LEFT JOIN usuarios ON usuarios.id = consultas.usuario_id
        WHERE consultas.id = :id
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ==============ATUALIZAR=========
public function atualizar($id, $dados)
{
    $sql = "
        UPDATE consultas SET
        paciente_id = :paciente_id,
        usuario_id = :usuario_id,
        data = :data,
        hora = :hora,
        procedimento = :procedimento,
        observacoes = :observacoes,
        status = :status
        WHERE id = :id
    ";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(":paciente_id", $dados['paciente_id']);
    $stmt->bindValue(":usuario_id", $dados['usuario_id']);
    $stmt->bindValue(":data", $dados['data']);
    $stmt->bindValue(":hora", $dados['hora']);
    $stmt->bindValue(":procedimento", $dados['procedimento']);
    $stmt->bindValue(":observacoes", $dados['observacoes']);
    $stmt->bindValue(":status", $dados['status']);
    $stmt->bindValue(":id", $id);

    return $stmt->execute();
}
}