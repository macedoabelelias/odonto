<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<title>Login - Odonto</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    height:100vh;
    background: linear-gradient(135deg,#eef2ff,#dbeafe,#e9d5ff);
    display:flex;
    align-items:center;
    justify-content:center;
    font-family: 'Segoe UI', sans-serif;
}

.login-card{
    background:
        linear-gradient(rgba(142, 160, 238, 0.85), rgba(255,255,255,0.85)),
        url('<?= BASE_URL ?>/assets/img/fundo-login.jpg');

    background-size:cover;
    background-position:center;

    border-radius:20px;
    padding:40px;
    width:900px;

    box-shadow:0 20px 40px rgba(0,0,0,.3);
}

.btn-main{
    background:#6366f1;
    color:#fff;
    border:none;
}

.btn-main:hover{
    background:#4f46e5;
}

</style>

</head>


<body>

<?php require $viewFile; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>