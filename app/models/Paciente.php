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

        nome,
        cpf,
        data_nascimento,
        genero,
        estado_civil,
        escolaridade,
        profissao,
        tipo_sanguineo,

        telefone,
        whatsapp,
        email,
        instagram,

        cep,
        endereco,
        bairro,
        cidade,
        estado,
        convenio,

        responsavel_nome,
        responsavel_telefone,
        responsavel_cpf,
        responsavel_email,

        alergias,
        medicamentos,
        observacoes,
        foto

        ) VALUES (

        ?,?,?,?,?,?,?,?,
        ?,?,?,?,
        ?,?,?,?,?,?,
        ?,?,?,?,
        ?,?,?,?

        )

        ");

        return $sql->execute([

            $dados['nome'] ?? null,
            $dados['cpf'] ?? null,
            $dados['data_nascimento'] ?? null,
            $dados['genero'] ?? null,
            $dados['estado_civil'] ?? null,
            $dados['escolaridade'] ?? null,
            $dados['profissao'] ?? null,
            $dados['tipo_sanguineo'] ?? null,

            $dados['telefone'] ?? null,
            $dados['whatsapp'] ?? null,
            $dados['email'] ?? null,
            $dados['instagram'] ?? null,

            $dados['cep'] ?? null,
            $dados['endereco'] ?? null,
            $dados['bairro'] ?? null,
            $dados['cidade'] ?? null,
            $dados['estado'] ?? null,
            $dados['convenio'] ?? null,

            $dados['responsavel_nome'] ?? null,
            $dados['responsavel_telefone'] ?? null,
            $dados['responsavel_cpf'] ?? null,
            $dados['responsavel_email'] ?? null,

            $dados['alergias'] ?? null,
            $dados['medicamentos'] ?? null,
            $dados['observacoes'] ?? null,
            $dados['foto'] ?? null
        ]);
    }


    /* ==========================
       ATUALIZAR
    ========================== */
    public function atualizar($id, $dados)
    {

        $sql = $this->pdo->prepare("

        UPDATE pacientes SET

        nome = ?,
        cpf = ?,
        data_nascimento = ?,
        genero = ?,
        estado_civil = ?,
        escolaridade = ?,
        profissao = ?,
        tipo_sanguineo = ?,

        telefone = ?,
        whatsapp = ?,
        email = ?,
        instagram = ?,

        cep = ?,
        endereco = ?,
        bairro = ?,
        cidade = ?,
        estado = ?,
        convenio = ?,

        responsavel_nome = ?,
        responsavel_telefone = ?,
        responsavel_cpf = ?,
        responsavel_email = ?,

        alergias = ?,
        medicamentos = ?,
        observacoes = ?,
        foto = ?

        WHERE id = ?

        ");

        return $sql->execute([

            $dados['nome'] ?? null,
            $dados['cpf'] ?? null,
            $dados['data_nascimento'] ?? null,
            $dados['genero'] ?? null,
            $dados['estado_civil'] ?? null,
            $dados['escolaridade'] ?? null,
            $dados['profissao'] ?? null,
            $dados['tipo_sanguineo'] ?? null,

            $dados['telefone'] ?? null,
            $dados['whatsapp'] ?? null,
            $dados['email'] ?? null,
            $dados['instagram'] ?? null,

            $dados['cep'] ?? null,
            $dados['endereco'] ?? null,
            $dados['bairro'] ?? null,
            $dados['cidade'] ?? null,
            $dados['estado'] ?? null,
            $dados['convenio'] ?? null,

            $dados['responsavel_nome'] ?? null,
            $dados['responsavel_telefone'] ?? null,
            $dados['responsavel_cpf'] ?? null,
            $dados['responsavel_email'] ?? null,

            $dados['alergias'] ?? null,
            $dados['medicamentos'] ?? null,
            $dados['observacoes'] ?? null,
            $dados['foto'] ?? null,

            $id
        ]);
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