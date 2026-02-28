<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">

<?php
require_once 'config/conexao.php';
$configSistema = $pdo->query("SELECT nome_clinica FROM configuracoes LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>
<title><?= $configSistema['nome_clinica'] ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background:#f4f6f9;
}

.wrapper{
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:230px;
    min-height:100vh;
    background: linear-gradient(180deg,#4f46e5,#6366f1);
    color:#fff;
    padding:20px 0;
}

.sidebar h4{
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:#fff;
    padding:12px 20px;
    text-decoration:none;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.15);
}

/* MAIN */
.main{
    flex:1;
    display:flex;
    flex-direction:column;
}

/* NAVBAR */
.navbar-top{
    background:#fff;
    padding:15px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* CONTENT */
.content{
    padding:30px;
}

/* CONFIG MENU */
.user-area{
    position:relative;
    display:flex;
    align-items:center;
    gap:10px;
}

.btn-config{
    background:transparent;
    border:none;
    font-size:18px;
    cursor:pointer;
}

.menu-config{
    position:absolute;
    top:35px;
    right:0;
    background:#fff;
    border-radius:8px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
    display:none;
    flex-direction:column;
    min-width:180px;
    padding:10px 0;
    z-index:999;
}

.menu-config a{
    padding:8px 15px;
    text-decoration:none;
    color:#333;
    display:block;
}

.menu-config a:hover{
    background:#f1f1f1;
}

/* .logo-area img{
    background: white;
    padding:10px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
} */

 .logo-sidebar{
    max-width:190px;
    border-radius:10px;
}
</style>
</head>

<body>

<div class="wrapper">