<?php

class Orcamento {

    private $pdo;

    public function __construct() {
        require BASE_PATH . "/config/conexao.php";
        $this->pdo = $pdo;
    }

    // ================= SALVAR =================
    public function salvar($paciente_id, $itens) {

        try {

            $resolverStatus = function($item) {

                $status = 'planejado';

                if(!empty($item['status'])){
                    $status = strtolower(trim($item['status']));
                }

                if(empty($item['status']) && !empty($item['dente']) && !empty($item['nome'])){

                    $sqlStatus = $this->pdo->prepare("
                        SELECT status 
                        FROM prontuarios_registros 
                        WHERE dente = :dente 
                        AND procedimento = :proc
                        ORDER BY id DESC
                        LIMIT 1
                    ");

                    $sqlStatus->execute([
                        ':dente' => $item['dente'],
                        ':proc' => $item['nome']
                    ]);

                    $result = $sqlStatus->fetch(PDO::FETCH_ASSOC);

                    if($result && !empty($result['status'])){
                        $status = strtolower(trim($result['status']));
                    }
                }

                $validos = ['planejado','andamento','realizado','cancelado','existente'];

                if(!in_array($status, $validos)){
                    $status = 'planejado';
                }

                return $status;
            };

            // ================= CALCULAR TOTAL =================
            $total = 0;

            foreach($itens as $i){

                $status = $resolverStatus($i);

                $valor = 0;

                if($status !== 'existente' && $status !== 'cancelado'){
                    $valor = floatval($i['valor'] ?? 0);
                }

                $total += $valor;
            }

            // ================= VERIFICA EXISTENTE =================
            $sqlCheck = $this->pdo->prepare("
                SELECT id FROM orcamentos
                WHERE paciente_id = :paciente
                AND status = 'pendente'
                ORDER BY id DESC
                LIMIT 1
            ");

            $sqlCheck->execute([':paciente' => $paciente_id]);
            $existente = $sqlCheck->fetch(PDO::FETCH_ASSOC);

            if($existente){

                $orcamento_id = $existente['id'];

                $sql = $this->pdo->prepare("
                    UPDATE orcamentos 
                    SET total = :total
                    WHERE id = :id
                ");

                $sql->execute([
                    ':total' => $total,
                    ':id' => $orcamento_id
                ]);

                // 🔥 limpa itens antigos
                $this->pdo->prepare("
                    DELETE FROM orcamentos_itens 
                    WHERE orcamento_id = ?
                ")->execute([$orcamento_id]);

            } else {

                $sql = $this->pdo->prepare("
                    INSERT INTO orcamentos (paciente_id, total, status)
                    VALUES (?, ?, 'pendente')
                ");

                $sql->execute([$paciente_id, $total]);

                $orcamento_id = $this->pdo->lastInsertId();
            }

            // ================= SALVAR ITENS =================
            foreach($itens as $item){

                $status = $resolverStatus($item);

                $valorOriginal = floatval($item['valor'] ?? 0);

                $sqlItem = $this->pdo->prepare("
                    INSERT INTO orcamentos_itens 
                    (orcamento_id, procedimento, valor, dente, status)
                    VALUES (?, ?, ?, ?, ?)
                ");

                $sqlItem->execute([
                    $orcamento_id,
                    $item['nome'] ?? '',
                    $valorOriginal,
                    $item['dente'] ?? null,
                    $status
                ]);
            }

            return $orcamento_id;

        } catch(Exception $e){
            return false;
        }
    }

    // ================= PEGAR ÚLTIMO =================
    public function ultimo($paciente_id)
    {
        $sql = $this->pdo->prepare("
            SELECT * FROM orcamentos
            WHERE paciente_id = :paciente_id
            ORDER BY id DESC
            LIMIT 1
        ");

        $sql->execute([
            ':paciente_id' => $paciente_id
        ]);

        $orcamento = $sql->fetch(PDO::FETCH_ASSOC);

        if(!$orcamento){
            return [];
        }

        $sqlItens = $this->pdo->prepare("
            SELECT id, procedimento, valor, dente, status
            FROM orcamentos_itens
            WHERE orcamento_id = :orcamento_id
        ");

        $sqlItens->execute([
            ':orcamento_id' => $orcamento['id']
        ]);

        $orcamento['itens'] = $sqlItens->fetchAll(PDO::FETCH_ASSOC);

        return $orcamento;
    }

     // ================= LISTAR ORÇAMENTOS =================
    public function listarOrcamentosAgrupados($paciente_id)
    {
        $sql = $this->pdo->prepare("
            SELECT id, total, status, criado_em
            FROM orcamentos
            WHERE paciente_id = :paciente
            ORDER BY id DESC
        ");

        $sql->execute([
            ':paciente' => $paciente_id
        ]);

        $orcamentos = $sql->fetchAll(PDO::FETCH_ASSOC);

        if(!$orcamentos){
            return [];
        }

        foreach($orcamentos as &$orc){

            $itens = $this->pdo->prepare("
                SELECT procedimento, valor, dente, status
                FROM orcamentos_itens
                WHERE orcamento_id = :id
            ");

            $itens->execute([
                ':id' => $orc['id']
            ]);

            $orc['itens'] = $itens->fetchAll(PDO::FETCH_ASSOC);
        }

        return $orcamentos;
    }

// ================= ITENS DO ORÇAMENTO =================
public function itensDoOrcamento($orcamento_id)
{
    $sql = $this->pdo->prepare("
        SELECT procedimento, valor, dente, status
        FROM orcamentos_itens
        WHERE orcamento_id = :id
    ");

    $sql->execute([
        ':id' => $orcamento_id
    ]);

    return $sql->fetchAll(PDO::FETCH_ASSOC);
} 

// ================= ATUALIZAR STATUS DO ITEM =================
public function atualizarStatusItem($id, $status)
{
    $sql = $this->pdo->prepare("
        UPDATE orcamentos_itens
        SET status = :status
        WHERE id = :id
    ");

    $sql->execute([
        ':status' => $status,
        ':id' => $id
    ]);

    return true;
}

// ================= BUSCAR ITEM =================
public function buscarItem($id)
{
    $sql = $this->pdo->prepare("
        SELECT oi.*, o.paciente_id
        FROM orcamentos_itens oi
        INNER JOIN orcamentos o ON o.id = oi.orcamento_id
        WHERE oi.id = :id
        LIMIT 1
    ");

    $sql->execute([
        ':id' => $id
    ]);

    return $sql->fetch(PDO::FETCH_ASSOC);
}

// ================= LISTAR POR PACIENTE =================
public function listarPorPaciente($paciente_id)
{
    $sql = $this->pdo->prepare("
        SELECT *
        FROM orcamentos
        WHERE paciente_id = :paciente
        ORDER BY id DESC
    ");

    $sql->execute([
        ':paciente' => $paciente_id
    ]);

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// ================= APROVAR =================
public function aprovar($id)
{
    $sql = $this->pdo->prepare("
        UPDATE orcamentos
        SET status = 'aprovado'
        WHERE id = :id
    ");

    return $sql->execute([
        ':id' => $id
    ]);
}

// ================= LIMPAR =================
public function limparPorPaciente($paciente_id)
{
    $sql = $this->pdo->prepare("
        DELETE FROM orcamentos
        WHERE paciente_id = :paciente
    ");

    return $sql->execute([
        ':paciente' => $paciente_id
    ]);
}

public function buscarPorId($id)
{
    $sql = $this->pdo->prepare("
        SELECT *
        FROM orcamentos
        WHERE id = ?
    ");

    $sql->execute([$id]);

    $orcamento = $sql->fetch(PDO::FETCH_ASSOC);

    if(!$orcamento){
        return [];
    }

    $sqlItens = $this->pdo->prepare("
        SELECT *
        FROM orcamentos_itens
        WHERE orcamento_id = ?
    ");

    $sqlItens->execute([$id]);

    $orcamento['itens'] = $sqlItens->fetchAll(PDO::FETCH_ASSOC);

    return $orcamento;
}
    
}