<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔐 DADOS DO USUÁRIO
$nivel = $_SESSION['usuario_nivel'] ?? '';
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';
$fotoUsuario = $_SESSION['usuario_foto'] ?? '';

// caminho da foto
$fotoPath = !empty($fotoUsuario)
    ? BASE_URL . "/assets/img/usuarios/" . $fotoUsuario
    : BASE_URL . "/assets/img/user.png"; // imagem padrão

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>AM Systems Odontologia</title>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<!-- 🔥 LUCIDE -->
<script src="https://unpkg.com/lucide@latest"></script>

</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <?php require BASE_PATH . "/app/views/layout/sidebar.php"; ?>

    <div class="flex-grow-1">

        <!-- NAVBAR -->
        <?php require BASE_PATH . "/app/views/layout/navbar.php"; ?>

        <!-- CONTEÚDO -->
        <div class="page-wrapper">
        <div class="container-fluid mt-4">