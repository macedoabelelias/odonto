<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'config/conexao.php';

/* ================= VALIDAÇÃO DE ACESSO ================= */

if (!isset($_SESSION['usuario_id'])) {
    die("Acesso não autorizado.");
}

$usuarioLogado = $_SESSION['usuario_id'];
$nivelLogado   = $_SESSION['usuario_nivel'] ?? '';

$id = $_POST['id'] ?? null;

/* 
   Se não for admin e tentar editar outro usuário → bloqueia
*/
if ($nivelLogado !== 'admin' && $id != $usuarioLogado) {
    die("Você só pode editar seu próprio perfil.");
}

/* ================= CAPTURA DOS DADOS ================= */

$nome  = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$nivel = $_POST['nivel'] ?? 'dentista';

$cpf  = $_POST['cpf'] ?? null;
$telefone = $_POST['telefone'] ?? null;
$data_nascimento = $_POST['data_nascimento'] ?? null;

$cep = $_POST['cep'] ?? null;
$endereco = $_POST['endereco'] ?? null;
$bairro = $_POST['bairro'] ?? null;
$numero = $_POST['numero'] ?? null;
$cidade = $_POST['cidade'] ?? null;
$uf = $_POST['uf'] ?? null;

$registro_conselho = $_POST['registro_conselho'] ?? null;
$especialidade = $_POST['especialidade'] ?? null;

$fotoNome = null;

/* ================= UPLOAD FOTO ================= */

if (!empty($_FILES['foto']['name'])) {

    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg','jpeg','png','webp'];

    if (in_array($ext, $permitidas)) {

        $fotoNome = uniqid('user_') . "." . $ext;

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            "uploads/" . $fotoNome
        );
    }
}

/* ================= NOVO USUÁRIO ================= */

if (empty($id)) {

    if ($nivelLogado !== 'admin') {
        die("Apenas administrador pode criar usuários.");
    }

    if (empty($senha)) {
        die("Senha é obrigatória para novo usuário.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = $pdo->prepare("
        INSERT INTO usuarios 
        (nome,email,senha,nivel,foto,
         cpf,telefone,data_nascimento,
         cep,endereco,bairro,numero,cidade,uf,
         registro_conselho,especialidade)
        VALUES
        (:nome,:email,:senha,:nivel,:foto,
         :cpf,:telefone,:data_nascimento,
         :cep,:endereco,:bairro,:numero,:cidade,:uf,
         :registro_conselho,:especialidade)
    ");

    $sql->execute([
        ':nome'=>$nome,
        ':email'=>$email,
        ':senha'=>$senhaHash,
        ':nivel'=>$nivel,
        ':foto'=>$fotoNome,
        ':cpf'=>$cpf,
        ':telefone'=>$telefone,
        ':data_nascimento'=>$data_nascimento,
        ':cep'=>$cep,
        ':endereco'=>$endereco,
        ':bairro'=>$bairro,
        ':numero'=>$numero,
        ':cidade'=>$cidade,
        ':uf'=>$uf,
        ':registro_conselho'=>$registro_conselho,
        ':especialidade'=>$especialidade
    ]);

} else {

    /* ================= UPDATE ================= */

    /* Atualiza senha se informada */
    if (!empty($senha)) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $pdo->prepare("
            UPDATE usuarios 
            SET senha = :senha 
            WHERE id = :id
        ")->execute([
            ':senha'=>$senhaHash,
            ':id'=>$id
        ]);
    }

    /* Atualiza foto se enviada */
    if ($fotoNome) {

        $pdo->prepare("
            UPDATE usuarios 
            SET foto = :foto 
            WHERE id = :id
        ")->execute([
            ':foto'=>$fotoNome,
            ':id'=>$id
        ]);
    }

    /* Monta query dinâmica */
    $query = "
        UPDATE usuarios SET
            nome = :nome,
            email = :email,
            cpf = :cpf,
            telefone = :telefone,
            data_nascimento = :data_nascimento,
            cep = :cep,
            endereco = :endereco,
            bairro = :bairro,
            numero = :numero,
            cidade = :cidade,
            uf = :uf,
            registro_conselho = :registro_conselho,
            especialidade = :especialidade
    ";

    /* Só admin pode alterar nível */
    if ($nivelLogado === 'admin') {
        $query .= ", nivel = :nivel";
    }

    $query .= " WHERE id = :id";

    $stmt = $pdo->prepare($query);

    $params = [
        ':nome'=>$nome,
        ':email'=>$email,
        ':cpf'=>$cpf,
        ':telefone'=>$telefone,
        ':data_nascimento'=>$data_nascimento,
        ':cep'=>$cep,
        ':endereco'=>$endereco,
        ':bairro'=>$bairro,
        ':numero'=>$numero,
        ':cidade'=>$cidade,
        ':uf'=>$uf,
        ':registro_conselho'=>$registro_conselho,
        ':especialidade'=>$especialidade,
        ':id'=>$id
    ];

    if ($nivelLogado === 'admin') {
        $params[':nivel'] = $nivel;
    }

    $stmt->execute($params);
}

/* ================= REDIRECIONAMENTO ================= */

if ($nivelLogado === 'admin') {
    header("Location: usuarios.php");
} else {
    header("Location: meu_perfil.php?sucesso=1");
}

exit;