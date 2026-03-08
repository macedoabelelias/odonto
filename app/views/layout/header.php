<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>AM Systems Odontologia</title>

<link rel="stylesheet" href="/odonto/public/assets/css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>

<body>

<?php require BASE_PATH . "/app/views/layout/sidebar.php"; ?>

<?php require BASE_PATH . "/app/views/layout/navbar.php"; ?>

<div class="page-wrapper">