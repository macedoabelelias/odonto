<?php

require_once BASE_PATH . "/core/Model.php";

class Compra extends Model
{
    public function listar()
    {
        $sql = "SELECT c.*, f.nome as fornecedor 
                FROM compras c
                LEFT JOIN fornecedores f ON f.id = c.fornecedor_id
                ORDER BY c.id DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar($dados, $itens)
{
    try {
        $this->pdo->beginTransaction();

        $valorTotal = 0;

        // 🔥 validações básicas
        if (empty($dados['fornecedor_id'])) {
            throw new Exception("Fornecedor é obrigatório");
        }

        if (empty($dados['data'])) {
            throw new Exception("Data é obrigatória");
        }

        // 🔥 cria compra com total zerado
        $stmt = $this->pdo->prepare("
            INSERT INTO compras (fornecedor_id, data, valor_total)
            VALUES (:fornecedor_id, :data, 0)
        ");

        $stmt->execute([
            ':fornecedor_id' => $dados['fornecedor_id'],
            ':data' => $dados['data']
        ]);

        $compra_id = $this->pdo->lastInsertId();

        // 🔥 percorre itens
        foreach ($itens as $item) {

            if (empty($item['produto_id']) || empty($item['quantidade'])) {
                continue;
            }

            $produto_id = (int) $item['produto_id'];
            $quantidade = (int) $item['quantidade'];

            // 🔥 custo seguro
            $custo = str_replace('.', '', $item['custo'] ?? '0');
            $custo = str_replace(',', '.', $custo);
            $custo = (float) $custo;

            // evita valores inválidos
            if ($quantidade <= 0 || $custo < 0) {
                continue;
            }

            $subtotal = $quantidade * $custo;
            $valorTotal += $subtotal;

            // 🔥 inserir item
            $this->pdo->prepare("
                INSERT INTO compras_itens 
                (compra_id, produto_id, quantidade, custo)
                VALUES (:compra_id, :produto_id, :quantidade, :custo)
            ")->execute([
                ':compra_id' => $compra_id,
                ':produto_id' => $produto_id,
                ':quantidade' => $quantidade,
                ':custo' => $custo
            ]);

            // 🔥 atualizar estoque
            $this->pdo->prepare("
                UPDATE produtos 
                SET estoque = estoque + :qtd 
                WHERE id = :id
            ")->execute([
                ':qtd' => $quantidade,
                ':id' => $produto_id
            ]);
        }

        // 🔥 segurança: evita salvar compra sem itens
        if ($valorTotal <= 0) {
            throw new Exception("A compra precisa ter pelo menos um item válido.");
        }

        // 🔥 atualiza total REAL
        $this->pdo->prepare("
            UPDATE compras 
            SET valor_total = :total
            WHERE id = :id
        ")->execute([
            ':total' => $valorTotal,
            ':id' => $compra_id
        ]);

        $this->pdo->commit();

    } catch (Exception $e) {
        $this->pdo->rollBack();
        die("Erro ao salvar compra: " . $e->getMessage());
    }
}

    public function buscarPorId($id)
    {
        $sql = "SELECT c.*, f.nome as fornecedor
                FROM compras c
                LEFT JOIN fornecedores f ON f.id = c.fornecedor_id
                WHERE c.id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $compra = $stmt->fetch(PDO::FETCH_ASSOC);

        $sqlItens = "SELECT i.*, p.nome as produto
                     FROM compras_itens i
                     LEFT JOIN produtos p ON p.id = i.produto_id
                     WHERE i.compra_id = :id";

        $stmtItens = $this->pdo->prepare($sqlItens);
        $stmtItens->execute([':id' => $id]);

        $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

        return [
            'compra' => $compra,
            'itens' => $itens
        ];
    }

    // 🔥 EXCLUIR COM AJUSTE DE ESTOQUE
    public function excluir($id)
    {
        try {
            $this->pdo->beginTransaction();

            // buscar itens
            $stmt = $this->pdo->prepare("
                SELECT produto_id, quantidade 
                FROM compras_itens 
                WHERE compra_id = :id
            ");
            $stmt->execute([':id' => $id]);
            $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // remover estoque
            foreach ($itens as $item) {
                $this->pdo->prepare("
                    UPDATE produtos 
                    SET estoque = estoque - :qtd 
                    WHERE id = :id
                ")->execute([
                    ':qtd' => $item['quantidade'],
                    ':id' => $item['produto_id']
                ]);
            }

            // apagar itens
            $this->pdo->prepare("DELETE FROM compras_itens WHERE compra_id = ?")
                      ->execute([$id]);

            // apagar compra
            $this->pdo->prepare("DELETE FROM compras WHERE id = ?")
                      ->execute([$id]);

            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            die("Erro ao excluir compra: " . $e->getMessage());
        }
    }

    // 🔥 ATUALIZAR COM AJUSTE DE ESTOQUE
    public function atualizar($id, $dados, $itens)
    {
        try {
            $this->pdo->beginTransaction();

            // 🔥 buscar itens antigos
            $stmtOld = $this->pdo->prepare("
                SELECT produto_id, quantidade 
                FROM compras_itens 
                WHERE compra_id = :id
            ");
            $stmtOld->execute([':id' => $id]);
            $itensAntigos = $stmtOld->fetchAll(PDO::FETCH_ASSOC);

            // 🔥 remover estoque antigo
            foreach ($itensAntigos as $item) {
                $this->pdo->prepare("
                    UPDATE produtos 
                    SET estoque = estoque - :qtd 
                    WHERE id = :id
                ")->execute([
                    ':qtd' => $item['quantidade'],
                    ':id' => $item['produto_id']
                ]);
            }

            // 🔥 atualizar compra
            $this->pdo->prepare("
                UPDATE compras 
                SET fornecedor_id = :fornecedor_id,
                    data = :data,
                    valor_total = :total
                WHERE id = :id
            ")->execute([
                ':fornecedor_id' => $dados['fornecedor_id'],
                ':data' => $dados['data'],
                ':total' => $dados['valor_total'],
                ':id' => $id
            ]);

            // apagar itens antigos
            $this->pdo->prepare("DELETE FROM compras_itens WHERE compra_id = ?")
                      ->execute([$id]);

            // 🔥 inserir novos + somar estoque
            foreach ($itens as $item) {

                $quantidade = (int) $item['quantidade'];
                $custo = str_replace(',', '.', $item['custo'] ?? 0);

                $this->pdo->prepare("
                    INSERT INTO compras_itens 
                    (compra_id, produto_id, quantidade, custo)
                    VALUES (:compra_id, :produto_id, :quantidade, :custo)
                ")->execute([
                    ':compra_id' => $id,
                    ':produto_id' => $item['produto_id'],
                    ':quantidade' => $quantidade,
                    ':custo' => $custo
                ]);

                $this->pdo->prepare("
                    UPDATE produtos 
                    SET estoque = estoque + :qtd 
                    WHERE id = :id
                ")->execute([
                    ':qtd' => $quantidade,
                    ':id' => $item['produto_id']
                ]);
            }

            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            die("Erro ao atualizar compra: " . $e->getMessage());
        }
    }

    public function atualizarTotal($compraId)
{
    $sql = $this->pdo->prepare("
        SELECT SUM(quantidade * valor_unitario) as total
        FROM compras_itens
        WHERE compra_id = :compra_id
    ");
    $sql->bindValue(":compra_id", $compraId);
    $sql->execute();

    $total = $sql->fetch()['total'] ?? 0;

    // Atualiza na tabela compras
    $update = $this->pdo->prepare("
        UPDATE compras SET total = :total WHERE id = :id
    ");
    $update->bindValue(":total", $total);
    $update->bindValue(":id", $compraId);
    $update->execute();
}
}