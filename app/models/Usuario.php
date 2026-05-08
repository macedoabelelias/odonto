<?php

require_once BASE_PATH . "/core/Database.php";

class Usuario {

    private $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    /* ================================
       LISTAR USUÁRIOS
    ================================= */
    public function listar()
    {
        $sql = "
            SELECT 
                u.*, 
                n.nome as nivel_nome
            FROM usuarios u
            LEFT JOIN niveis n ON n.id = u.nivel_id
            ORDER BY u.nome
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ================================
       BUSCAR POR ID
    ================================= */
    public function buscar($id)
    {
        $sql = $this->pdo->prepare("
            SELECT u.*, n.nome as nivel_nome
            FROM usuarios u
            LEFT JOIN niveis n ON n.id = u.nivel_id
            WHERE u.id = :id
            LIMIT 1
        ");

        $sql->bindValue(":id", $id);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    /* ================================
       BUSCAR POR EMAIL
    ================================= */
    public function buscarPorEmail($email){
        $sql = $this->pdo->prepare("
            SELECT u.*, n.nome as nivel_nome
            FROM usuarios u
            LEFT JOIN niveis n ON n.id = u.nivel_id
            WHERE u.email = :email
            LIMIT 1
        ");

        $sql->bindValue(":email",$email);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    /* ================================
       CRIAR USUÁRIO
    ================================= */
public function criar($dados){

    $senha = password_hash($dados["senha"], PASSWORD_DEFAULT);

    $sql = $this->pdo->prepare("
        INSERT INTO usuarios (
            nome, email, senha, nivel_id,
            cpf_cnpj, data_nascimento, telefone,
            cep, endereco, numero, bairro, cidade, estado,
            especialidade, registro_conselho,
            cargo, forma_pagamento_id, chave_pix, foto
        ) VALUES (
            :nome, :email, :senha, :nivel_id,
            :cpf_cnpj, :data_nascimento, :telefone,
            :cep, :endereco, :numero, :bairro, :cidade, :estado,
            :especialidade, :registro_conselho,
            :cargo, :forma_pagamento_id, :chave_pix, :foto
        )
    ");

    return $sql->execute([
        ':nome' => $dados['nome'],
        ':email' => $dados['email'],
        ':senha' => $senha,
        ':nivel_id' => $dados['nivel_id'],
        ':cpf_cnpj' => $dados['cpf_cnpj'] ?? null,
        ':data_nascimento' => $dados['data_nascimento'] ?? null,
        ':telefone' => $dados['telefone'] ?? null,
        ':cep' => $dados['cep'] ?? null,
        ':endereco' => $dados['endereco'] ?? null,
        ':numero' => $dados['numero'] ?? null,
        ':bairro' => $dados['bairro'] ?? null,
        ':cidade' => $dados['cidade'] ?? null,
        ':estado' => $dados['estado'] ?? null,
        ':especialidade' => $dados['especialidade'] ?? null,
        ':registro_conselho' => $dados['registro_conselho'] ?? null,
        ':cargo' => $dados['cargo'] ?? null,
        ':forma_pagamento_id' => $dados['forma_pagamento_id'] ?? null,
        ':chave_pix' => $dados['chave_pix'] ?? null,
        ':foto' => $dados['foto'] ?? null
    ]);
}

    /* ================================
       ATUALIZAR USUÁRIO
    ================================= */
public function atualizar($dados){

    $sql = $this->pdo->prepare("
        UPDATE usuarios SET
            nome = :nome,
            email = :email,
            nivel_id = :nivel_id,
            cpf_cnpj = :cpf_cnpj,
            data_nascimento = :data_nascimento,
            telefone = :telefone,
            cep = :cep,
            endereco = :endereco,
            numero = :numero,
            bairro = :bairro,
            cidade = :cidade,
            estado = :estado,
            especialidade = :especialidade,
            registro_conselho = :registro_conselho,
            cargo = :cargo,
            forma_recebimento = :forma_recebimento,
            forma_pagamento_id = :forma_pagamento_id,
            chave_pix = :chave_pix
        WHERE id = :id
    ");

    return $sql->execute([
        ':nome' => $dados['nome'],
        ':email' => $dados['email'],
        ':nivel_id' => $dados['nivel_id'],
        ':cpf_cnpj' => $dados['cpf_cnpj'] ?? null,
        ':data_nascimento' => $dados['data_nascimento'] ?? null,
        ':telefone' => $dados['telefone'] ?? null,
        ':cep' => $dados['cep'] ?? null,
        ':endereco' => $dados['endereco'] ?? null,
        ':numero' => $dados['numero'] ?? null,
        ':bairro' => $dados['bairro'] ?? null,
        ':cidade' => $dados['cidade'] ?? null,
        ':estado' => $dados['estado'] ?? null,
        ':especialidade' => $dados['especialidade'] ?? null,
        ':registro_conselho' => $dados['registro_conselho'] ?? null,
        ':cargo' => $dados['cargo'] ?? null,
        ':forma_recebimento' => $dados['forma_recebimento'] ?? null,
        ':forma_pagamento_id' => $dados['forma_pagamento_id'] ?? null,
        ':chave_pix' => $dados['chave_pix'] ?? null,
        ':id' => $dados['id']
    ]);
}

    /* ================================
       EXCLUIR USUÁRIO
    ================================= */
public function excluir($id)
{
    try {

        // 🔥 1. EXCLUI DEPENDÊNCIAS (comissões)
        $sql = $this->pdo->prepare("
            DELETE FROM comissoes 
            WHERE usuario_id = :id
        ");
        $sql->bindValue(":id", $id);
        $sql->execute();

        // 🔥 2. AGORA EXCLUI O USUÁRIO
        $sql = $this->pdo->prepare("
            DELETE FROM usuarios 
            WHERE id = :id
        ");
        $sql->bindValue(":id", $id);

        return $sql->execute();

    } catch (PDOException $e) {

        // 🔥 DEBUG CONTROLADO (não quebra sistema)
        echo "Erro ao excluir usuário: " . $e->getMessage();
        return false;
    }
}

    /* ================================
       ALTERAR SENHA
    ================================= */
    public function alterarSenha($id,$senha){

        $senha = password_hash($senha,PASSWORD_DEFAULT);

        $sql = $this->pdo->prepare("
            UPDATE usuarios 
            SET senha = :senha 
            WHERE id = :id
        ");

        $sql->bindValue(":senha",$senha);
        $sql->bindValue(":id",$id);

        return $sql->execute();
    }

    /* ================================
       LISTAR DENTISTAS (CORRIGIDO)
    ================================= */
    public function listarDentistas(){

        $sql = "
            SELECT u.id, u.nome, u.registro_conselho
            FROM usuarios u
            INNER JOIN niveis n ON n.id = u.nivel_id
            WHERE n.nome = 'dentista'
            ORDER BY u.nome
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ================================
       RANKING DENTISTAS (NOVO 🔥)
    ================================= */
    
   public function rankingDentistasFaturamento()
{
    $sql = "
        SELECT 
            u.nome,
            COUNT(c.id) as total
        FROM consultas c
        INNER JOIN usuarios u ON u.id = c.usuario_id
        INNER JOIN niveis n ON n.id = u.nivel_id
        WHERE n.nome = 'dentista'
        GROUP BY u.id
        ORDER BY total DESC
    ";

    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

public function buscarPorId($id)
{
    $sql = $this->pdo->prepare("
        SELECT * 
        FROM usuarios 
        WHERE id = :id
    ");

    $sql->bindValue(":id", $id);
    $sql->execute();

    return $sql->fetch(PDO::FETCH_ASSOC);
}


public function rankingPorDentista($usuarioId)
{
    $sql = $this->pdo->prepare("
        SELECT 
            COALESCE(procedimento, 'Não informado') as procedimento,
            COUNT(*) as total
        FROM consultas
        WHERE usuario_id = :usuario
        GROUP BY procedimento
        ORDER BY total DESC
    ");

    $sql->bindValue(":usuario", $usuarioId);
    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

public function existeCPF($cpf, $id = null)
{
    $sql = "SELECT id FROM usuarios WHERE cpf_cnpj = :cpf";

    if($id){
        $sql .= " AND id != :id";
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":cpf", $cpf);

    if($id){
        $stmt->bindValue(":id", $id);
    }

    $stmt->execute();

    return $stmt->fetch();
}

public function existeEmail($email, $id = null)
{
    $sql = "SELECT id FROM usuarios WHERE email = :email";

    if($id){
        $sql .= " AND id != :id";
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":email", $email);

    if($id){
        $stmt->bindValue(":id", $id);
    }

    $stmt->execute();

    return $stmt->fetch();
}

}