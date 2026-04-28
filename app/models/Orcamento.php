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

        $total = 0;

        // 🔥 função interna para resolver status
        $resolverStatus = function($item) {

            $status = 'planejado';

            // 1. tenta do item
            if(!empty($item['status'])){
                $status = strtolower(trim($item['status']));
            }

            // 2. busca do prontuário
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

            // 3. valida
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

            // 🔥 DEFINE VALOR CORRETO
            $valor = 0;

            if($status !== 'existente' && $status !== 'cancelado'){
                $valor = floatval($i['valor'] ?? 0);
            }

            // 🔥 SOMA
            $total += $valor;
        }

        // ================= SALVAR ORÇAMENTO =================
        $sql = $this->pdo->prepare("
            INSERT INTO orcamentos (paciente_id, total)
            VALUES (?, ?)
        ");

        $sql->execute([$paciente_id, $total]);

        $orcamento_id = $this->pdo->lastInsertId();

        // ================= SALVAR ITENS =================
        foreach($itens as $item){

            $status = $resolverStatus($item);

            // 🔥 VALOR ORIGINAL (mantém para histórico)
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
    // 🔥 BUSCA O ÚLTIMO ORÇAMENTO
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

    // 🔥 BUSCA OS ITENS
  $sqlItens = $this->pdo->prepare("
    SELECT 
        id,                -- 🔥 ESSENCIAL
        procedimento,
        valor,
        dente,
        status
    FROM orcamentos_itens
    WHERE orcamento_id = :orcamento_id
");

    $sqlItens->execute([
        ':orcamento_id' => $orcamento['id']
    ]);

    $orcamento['itens'] = $sqlItens->fetchAll(PDO::FETCH_ASSOC);

    return $orcamento;
}
    // ================= LISTAR =================
public function listarPorPaciente($paciente_id)
{
    $sql = $this->pdo->prepare("
        SELECT 
            oi.procedimento AS procedimento_nome,
            oi.valor,
            oi.dente,
            oi.status,

            -- 🔥 fallback seguro
            CASE 
                WHEN oi.procedimento IS NULL OR oi.procedimento = '' 
                THEN 'Procedimento não informado'
                ELSE oi.procedimento
            END AS nome_exibicao

        FROM orcamentos o
        INNER JOIN orcamentos_itens oi 
            ON oi.orcamento_id = o.id
        WHERE o.paciente_id = :paciente_id
        ORDER BY o.id DESC
    ");

    $sql->execute([
        ':paciente_id' => $paciente_id
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

        $sql->execute([
            ':id' => $id
        ]);

        return true;
    }

    // ================= PEGAR ITENS =================
    public function itensDoOrcamento($orcamento_id)
    {
        $sql = $this->pdo->prepare("
            SELECT 
                procedimento, 
                valor, 
                dente,
                status
            FROM orcamentos_itens
            WHERE orcamento_id = :id
        ");

        $sql->execute([
            ':id' => $orcamento_id
        ]);

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= LIMPAR =================
    public function limparPorPaciente($paciente_id)
    {
        try {

            $this->pdo->beginTransaction();

            $sqlItens = $this->pdo->prepare("
                DELETE oi FROM orcamentos_itens oi
                INNER JOIN orcamentos o ON o.id = oi.orcamento_id
                WHERE o.paciente_id = :paciente_id
            ");
            $sqlItens->execute([':paciente_id' => $paciente_id]);

            $sqlOrc = $this->pdo->prepare("
                DELETE FROM orcamentos WHERE paciente_id = :paciente_id
            ");
            $sqlOrc->execute([':paciente_id' => $paciente_id]);

            $this->pdo->commit();

            return true;

        } catch (Exception $e) {

            $this->pdo->rollBack();
            return false;
        }
    }

    public function atualizarStatusItem($id, $status)
{
    $sql = $this->pdo->prepare("
        UPDATE orcamentos_itens 
        SET status = :status 
        WHERE id = :id
    ");

    return $sql->execute([
        ':status' => $status,
        ':id' => $id
    ]);
}

public function buscarItem($id)
{
    $sql = $this->pdo->prepare("
        SELECT 
            oi.procedimento,
            oi.dente,
            o.paciente_id
        FROM orcamentos_itens oi
        INNER JOIN orcamentos o 
            ON o.id = oi.orcamento_id
        WHERE oi.id = :id
    ");

    $sql->execute([':id' => $id]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}
}