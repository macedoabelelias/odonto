<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>AM Systems Odontologia</title>

<!-- CSS DO SISTEMA -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- BOOTSTRAP ICONS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>

<body>

<div class="d-flex">

<!-- SIDEBAR -->
<?php require BASE_PATH . "/app/views/layout/sidebar.php"; ?>

<div class="flex-grow-1">

<!-- NAVBAR -->
<?php require BASE_PATH . "/app/views/layout/navbar.php"; ?>

<div class="page-wrapper">
<div class="container-fluid mt-4">
