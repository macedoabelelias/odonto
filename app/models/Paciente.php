<?php

require_once BASE_PATH . "/core/Model.php";

class Paciente extends Model
{

/* ==========================
   LISTAR
========================== */

public function listar($usuario_id = null)
{
    if($usuario_id){
        $sql = "
            SELECT p.*, u.nome AS dentista_nome
            FROM pacientes p
            LEFT JOIN usuarios u ON u.id = p.usuario_id
            WHERE p.usuario_id = :usuario_id
            ORDER BY p.nome
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
    } else {
        $sql = "
            SELECT p.*, u.nome AS dentista_nome
            FROM pacientes p
            LEFT JOIN usuarios u ON u.id = p.usuario_id
            ORDER BY p.nome
        ";
        $stmt = $this->pdo->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function listarTodos()
{
    $sql = "
        SELECT 
            p.*, 
            u.nome AS dentista_nome
        FROM pacientes p
        LEFT JOIN usuarios u ON u.id = p.usuario_id
        WHERE p.status = 'ativo'
        ORDER BY p.id DESC
    ";

    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ==========================
   BUSCAR
========================== */

public function buscar($termo)
{
    $sql = $this->pdo->prepare("
        SELECT p.*, u.nome AS dentista_nome
        FROM pacientes p
        LEFT JOIN usuarios u ON u.id = p.usuario_id
        WHERE p.nome LIKE :termo
        OR p.cpf LIKE :termo
        ORDER BY p.id DESC
    ");

    $sql->bindValue(":termo", "%" . $termo . "%");
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function buscarAtivos($termo)
{
    $sql = $this->pdo->prepare("
        SELECT p.*, u.nome AS dentista_nome
        FROM pacientes p
        LEFT JOIN usuarios u ON u.id = p.usuario_id
        WHERE p.status = 'ativo'
        AND (p.nome LIKE :termo OR p.cpf LIKE :termo)
        ORDER BY p.id DESC
    ");

    $sql->bindValue(":termo", "%" . $termo . "%");
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function buscarPorUsuario($termo, $usuario_id)
{
    $sql = $this->pdo->prepare("
        SELECT p.*, u.nome AS dentista_nome
        FROM pacientes p
        LEFT JOIN usuarios u ON u.id = p.usuario_id
        WHERE p.usuario_id = :usuario_id
        AND (p.nome LIKE :termo OR p.cpf LIKE :termo)
        ORDER BY p.id DESC
    ");

    $sql->bindValue(":usuario_id", $usuario_id);
    $sql->bindValue(":termo", "%".$termo."%");
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

/* ==========================
   BUSCAR POR ID
========================== */

public function buscarPorId($id)
{
    $sql = $this->pdo->prepare("
        SELECT p.*, u.nome AS dentista_nome
        FROM pacientes p
        LEFT JOIN usuarios u ON u.id = p.usuario_id
        WHERE p.id = :id
        LIMIT 1
    ");

    $sql->bindValue(":id", (int)$id, PDO::PARAM_INT);
    $sql->execute();

    return $sql->fetch(PDO::FETCH_ASSOC) ?: [];
}

/* ==========================
   CPF
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
   SALVAR (mantido)
========================== */

public function salvar($dados)
{
    $sql = $this->pdo->prepare("INSERT INTO pacientes (
        usuario_id,nome,cpf,data_nascimento,genero,estado_civil,escolaridade,profissao,tipo_sanguineo,
        telefone,whatsapp,email,instagram,
        cep,endereco,bairro,cidade,estado,convenio,
        responsavel_nome,responsavel_telefone,responsavel_cpf,responsavel_email,
        alergias,medicamentos,observacoes,foto
    ) VALUES (
        ?,?,?,?,?,?,?,?,?,
        ?,?,?,?,
        ?,?,?,?,?,?,
        ?,?,?,?,
        ?,?,?,?
    )");

    return $sql->execute([
        $dados['usuario_id'] ?? null,
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
   RESTANTE (mantido)
========================== */

public function listarTodosComStatus()
{
    $sql = "
        SELECT p.*, u.nome AS dentista_nome
        FROM pacientes p
        LEFT JOIN usuarios u ON u.id = p.usuario_id
        ORDER BY p.id DESC
    ";

    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
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

    public function listarPorUsuario($usuario_id)
{
    $sql = "SELECT * FROM pacientes 
            WHERE usuario_id = :usuario_id
            ORDER BY nome";

    $stmt = $this->pdo->prepare($sql); // ✅
    $stmt->bindValue(':usuario_id', $usuario_id);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function totalAniversariantesHoje()
{
    $sql = $this->pdo->query("
        SELECT COUNT(*) as total
        FROM pacientes
        WHERE DAY(data_nascimento) = DAY(CURDATE())
        AND MONTH(data_nascimento) = MONTH(CURDATE())
    ");

    return $sql->fetch()['total'];
}

public function totalAniversariantesMes()
{
    $sql = $this->pdo->query("
        SELECT COUNT(*) as total
        FROM pacientes
        WHERE MONTH(data_nascimento) = MONTH(CURDATE())
    ");

    return $sql->fetch()['total'];
}

public function inativar($id)
{
    $sql = $this->pdo->prepare("
        UPDATE pacientes 
        SET status = 'inativo' 
        WHERE id = :id
    ");

    $sql->bindValue(":id", $id);
    return $sql->execute();
}

public function reativar($id)
{
    $sql = $this->pdo->prepare("
        UPDATE pacientes 
        SET status = 'ativo' 
        WHERE id = :id
    ");

    $sql->bindValue(":id", $id);
    return $sql->execute();
}

}