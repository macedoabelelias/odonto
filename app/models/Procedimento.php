<?php

require_once BASE_PATH . "/core/Model.php";

class Procedimento extends Model
{
    public function listar()
    {
        return $this->pdo->query("SELECT * FROM procedimentos ORDER BY nome")
                         ->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔥 MÉTODO PRINCIPAL (USADO PELO CONTROLLER)
    public function buscar($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM procedimentos WHERE id = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($dados)
    {
        $sql = "INSERT INTO procedimentos 
        (nome, tipo, local, abrangencia, codigo_tuss, valor_particular, quantidade_us, icone)
        VALUES 
        (:nome, :tipo, :local, :abrangencia, :codigo_tuss, :valor_particular, :quantidade_us, :icone)";

        $stmt = $this->pdo->prepare($sql);
    
        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':tipo' => $dados['tipo'],
            ':local' => $dados['local'],
            ':abrangencia' => $dados['abrangencia'],
            ':codigo_tuss' => $dados['codigo_tuss'],
            ':valor_particular' => $dados['valor_particular'],
            ':quantidade_us' => $dados['quantidade_us'],
            ':icone' => $dados['icone']
        ]);
    }

    public function atualizar($id, $dados)
    {
        $sql = "UPDATE procedimentos SET 
            nome = :nome,
            tipo = :tipo,
            local = :local,
            abrangencia = :abrangencia,
            codigo_tuss = :codigo_tuss,
            valor_particular = :valor_particular,
            quantidade_us = :quantidade_us,
            icone = :icone
            WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':tipo' => $dados['tipo'],
            ':local' => $dados['local'],
            ':abrangencia' => $dados['abrangencia'],
            ':codigo_tuss' => $dados['codigo_tuss'],
            ':valor_particular' => $dados['valor_particular'],
            ':quantidade_us' => $dados['quantidade_us'],
            ':icone' => $dados['icone'],
            ':id' => $id
        ]);
    }

    public function atualizarStatusPorId($id, $status){

    $sql = "UPDATE procedimentos SET status = :status WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":status", $status);
    $stmt->bindValue(":id", $id);

    return $stmt->execute();
}

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM procedimentos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function calcularValor($procedimento, $convenio = null)
    {
        if ($convenio && !empty($procedimento['quantidade_us'])) {
            return $procedimento['quantidade_us'] * $convenio['valor_us'];
        }

        return $procedimento['valor_particular'];
    }
}