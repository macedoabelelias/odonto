<?php

require_once BASE_PATH . "/core/Model.php";

class Paciente extends Model
{
    /* ==========================
       LISTAR
    ========================== */
    public function listar()
    {
        $sql = $this->pdo->query("SELECT * FROM pacientes ORDER BY id DESC");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ==========================
       BUSCAR (Nome ou CPF)
    ========================== */
    public function buscar($termo)
    {
        $sql = $this->pdo->prepare("
            SELECT * FROM pacientes
            WHERE nome LIKE :termo
            OR cpf LIKE :termo
            ORDER BY id DESC
        ");

        $sql->bindValue(":termo", "%" . $termo . "%");
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ==========================
       BUSCAR POR ID
    ========================== */
    public function buscarPorId($id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM pacientes WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    /* ==========================
       VERIFICAR CPF EXISTENTE
    ========================== */
    public function cpfExiste($cpf, $ignorarId = null)
    {
        $sql = "SELECT id FROM pacientes WHERE cpf = :cpf";

        if ($ignorarId) {
            $sql .= " AND id != :id";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":cpf", $cpf);

        if ($ignorarId) {
            $stmt->bindValue(":id", $ignorarId);
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ==========================
       SALVAR
    ========================== */
    public function salvar($dados)
    {
        $sql = $this->pdo->prepare("
            INSERT INTO pacientes (
                foto, nome, telefone, email, cpf,
                data_nascimento, tipo_sanguineo,
                estado_civil, genero, profissao,
                cep, endereco, bairro, cidade, estado,
                convenio, instagram, whatsapp,
                responsavel_nome, responsavel_telefone,
                responsavel_email, responsavel_cpf,
                observacoes
            ) VALUES (
                :foto, :nome, :telefone, :email, :cpf,
                :data_nascimento, :tipo_sanguineo,
                :estado_civil, :genero, :profissao,
                :cep, :endereco, :bairro, :cidade, :estado,
                :convenio, :instagram, :whatsapp,
                :responsavel_nome, :responsavel_telefone,
                :responsavel_email, :responsavel_cpf,
                :observacoes
            )
        ");

        return $sql->execute($dados);
    }

    /* ==========================
       ATUALIZAR
    ========================== */
    public function atualizar($id, $dados)
    {
        $dados['id'] = $id;

        $sql = $this->pdo->prepare("
            UPDATE pacientes SET
                foto = :foto,
                nome = :nome,
                telefone = :telefone,
                email = :email,
                cpf = :cpf,
                data_nascimento = :data_nascimento,
                tipo_sanguineo = :tipo_sanguineo,
                estado_civil = :estado_civil,
                genero = :genero,
                profissao = :profissao,
                cep = :cep,
                endereco = :endereco,
                bairro = :bairro,
                cidade = :cidade,
                estado = :estado,
                convenio = :convenio,
                instagram = :instagram,
                whatsapp = :whatsapp,
                responsavel_nome = :responsavel_nome,
                responsavel_telefone = :responsavel_telefone,
                responsavel_email = :responsavel_email,
                responsavel_cpf = :responsavel_cpf,
                observacoes = :observacoes
            WHERE id = :id
        ");

        return $sql->execute($dados);
    }

    /* ==========================
       EXCLUIR
    ========================== */
    public function excluir($id)
    {
        $sql = $this->pdo->prepare("DELETE FROM pacientes WHERE id = :id");
        $sql->bindValue(":id", $id);
        return $sql->execute();
    }
}