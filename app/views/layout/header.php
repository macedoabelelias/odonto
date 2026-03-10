<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   DADOS DO USUÁRIO LOGADO
========================= */

$usuario_id = $_SESSION['usuario_id'] ?? null;
$usuario_nome = $_SESSION['usuario_nome'] ?? '';
$usuario_nivel = $_SESSION['usuario_nivel'] ?? '';
$usuario_foto = $_SESSION['usuario_foto'] ?? null;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>AM Systems Odontologia</title>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

</head>

<body>

<?php require BASE_PATH . "/app/views/layout/sidebar.php"; ?>

<?php require BASE_PATH . "/app/views/layout/navbar.php"; ?>

<div class="page-wrapper">
<div class="container-fluid mt-4">