<?php
session_start();
require 'config/conexao.php';

$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

// Verifica se campos foram enviados
if (empty($email) || empty($senha)) {
    header("Location: login.php?erro=campos");
    exit;
}

try {

    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if ($sql->rowCount() > 0) {

        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        // Verifica senha criptografada
        if (password_verify($senha, $usuario['senha'])) {

            // Cria sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];

            header("Location: dashboard.php");
            exit;

        } else {
            header("Location: login.php?erro=senha");
            exit;
        }

    } else {
        header("Location: login.php?erro=usuario");
        exit;
    }

} catch (Exception $e) {
    echo "Erro no sistema: " . $e->getMessage();
}