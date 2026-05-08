<?php

require_once BASE_PATH . "/core/Model.php";

class Comissao extends Model
{

    /* ==========================
       LISTAR COMISSÕES
    ========================== */
    public function listar($inicio = null, $fim = null)
    {
        $usuarioId = $_SESSION['usuario_id'] ?? null;
        $nivel = strtolower($_SESSION['usuario_nivel'] ?? '');

        $sql = "
            SELECT 
                c.*,
                u.nome as dentista
            FROM comissoes c
            LEFT JOIN usuarios u ON u.id = c.usuario_id
            WHERE 1=1
        ";

        // filtro por período
        if ($inicio && $fim) {
            $sql .= " AND c.data BETWEEN :inicio AND :fim";
        }

        // 🔥 dentista vê só o dele
        if ($nivel == 'dentista') {
            $sql .= " AND c.usuario_id = :usuario_id";
        }

        $sql .= " ORDER BY c.data DESC";

        $stmt = $this->pdo->prepare($sql);

        if ($inicio && $fim) {
            $stmt->bindValue(':inicio', $inicio);
            $stmt->bindValue(':fim', $fim);
        }

        if ($nivel == 'dentista') {
            $stmt->bindValue(':usuario_id', $usuarioId);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ==========================
       TOTAL POR PERÍODO
    ========================== */
    public function totalPeriodo($inicio, $fim)
    {
        $sql = "
            SELECT SUM(valor_comissao) as total
            FROM comissoes
            WHERE data BETWEEN :inicio AND :fim
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':inicio', $inicio);
        $stmt->bindValue(':fim', $fim);
        $stmt->execute();

        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        return (float)($r['total'] ?? 0);
    }


    /* ==========================
       RANKING DE DENTISTAS
    ========================== */
    public function rankingDentistas($inicio = null, $fim = null)
    {
        $sql = "
            SELECT 
                u.nome as profissional,
                SUM(c.valor_procedimento) as producao,
                SUM(c.valor_comissao) as comissao
            FROM comissoes c
            LEFT JOIN usuarios u ON u.id = c.usuario_id
            WHERE 1=1
        ";

        if ($inicio && $fim) {
            $sql .= " AND c.data BETWEEN :inicio AND :fim";
        }

        $sql .= " GROUP BY c.usuario_id ORDER BY producao DESC";

        $stmt = $this->pdo->prepare($sql);

        if ($inicio && $fim) {
            $stmt->bindValue(':inicio', $inicio);
            $stmt->bindValue(':fim', $fim);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /* ==========================
       CRIAR COMISSÃO (MANUAL)
    ========================== */
    public function criar($dados)
    {
        $sql = "INSERT INTO comissoes 
        (conta_receber_id, usuario_id, valor_procedimento, percentual, valor_comissao, data)
        VALUES (:conta, :usuario, :valor, :percentual, :comissao, :data)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':conta', $dados['conta_receber_id']);
        $stmt->bindValue(':usuario', $dados['usuario_id']);
        $stmt->bindValue(':valor', $dados['valor']);
        $stmt->bindValue(':percentual', $dados['percentual']);
        $stmt->bindValue(':comissao', $dados['comissao']);
        $stmt->bindValue(':data', $dados['data']);

        return $stmt->execute();
    }


    /* ==========================
       🔥 REGISTRAR AUTOMÁTICO (COM CONVÊNIO)
    ========================== */
    public function registrar($contaId)
    {
        $sql = $this->pdo->prepare("
            SELECT 
                cr.id,
                cr.valor,
                cr.profissional_id,
                cr.convenio_id,
                c.percentual as percentual_convenio
            FROM contas_receber cr
            LEFT JOIN convenios c ON c.id = cr.convenio_id
            WHERE cr.id = :id
        ");

        $sql->bindValue(":id", $contaId);
        $sql->execute();

        $conta = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$conta) return;

        // ⚠️ evita profissional null
        if (empty($conta['profissional_id'])) return;

        $valor = $conta['valor'];
        $usuario_id = $conta['profissional_id'];

        // 🔥 REGRA DE PERCENTUAL
        if (!empty($conta['percentual_convenio'])) {
            $percentual = $conta['percentual_convenio'];
        } else {
            $percentual = 40; // padrão (ajustamos depois se quiser)
        }

        $valorComissao = ($valor * $percentual) / 100;

        // evita duplicar comissão
        $check = $this->pdo->prepare("
            SELECT id FROM comissoes WHERE conta_receber_id = :conta
        ");
        $check->bindValue(':conta', $contaId);
        $check->execute();

        if ($check->fetch()) return;

        // salva
        $insert = $this->pdo->prepare("
            INSERT INTO comissoes 
            (conta_receber_id, usuario_id, valor_procedimento, percentual, valor_comissao, data)
            VALUES 
            (:conta, :usuario, :valor, :percentual, :comissao, NOW())
        ");

        $insert->bindValue(':conta', $contaId);
        $insert->bindValue(':usuario', $usuario_id);
        $insert->bindValue(':valor', $valor);
        $insert->bindValue(':percentual', $percentual);
        $insert->bindValue(':comissao', $valorComissao);

        $insert->execute();
    }
}