<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

// ====== BUSCA DADOS DO BANCO ======
try {

    $totalPacientes = $pdo->query("SELECT COUNT(*) FROM pacientes")->fetchColumn();
    $totalUsuarios  = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();

} catch (Exception $e) {
    $totalPacientes = 0;
    $totalUsuarios  = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Dashboard - Odonto</title>

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
    width:240px;
    min-height:100vh;
    background:linear-gradient(180deg,#4f46e5,#6366f1);
    color:#fff;
    padding:20px 0;
}

.sidebar h4{
    text-align:center;
    margin-bottom:30px;
    font-weight:bold;
}

.sidebar a{
    display:block;
    padding:12px 25px;
    color:#fff;
    text-decoration:none;
    font-size:14px;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.1);
}

/* MAIN */
.main{
    flex:1;
}

.navbar-top{
    background:#fff;
    padding:15px 25px;
    border-bottom:1px solid #ddd;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.content{
    padding:30px;
}

/* CARDS */
.card-box{
    border:none;
    border-radius:15px;
    padding:25px;
    color:#fff;
    box-shadow:0 10px 20px rgba(0,0,0,.1);
}

.bg-blue{
    background:linear-gradient(45deg,#3b82f6,#6366f1);
}

.bg-green{
    background:linear-gradient(45deg,#10b981,#22c55e);
}

.bg-orange{
    background:linear-gradient(45deg,#f59e0b,#f97316);
}

.bg-red{
    background:linear-gradient(45deg,#ef4444,#f43f5e);
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo-area text-center mb-4">
        <img src="/odonto/assets/img/logo9.png" 
         style="max-width:190px; border-radius:10px;">
    </div>

    <hr>
       

        <a href="dashboard.php">Dashboard</a>
        <a href="pacientes.php">Pacientes</a>
        <a href="#">Agendamentos</a>
        <a href="#">Consultas</a>
        <a href="#">Financeiro</a>
        <a href="#">Relatórios</a>

        <hr style="background:#fff; opacity:.2;">

        <a href="logout.php">Sair</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- NAVBAR -->
        <div class="navbar-top">
            <div>
                <strong>Painel Administrativo</strong>
            </div>
            <div>
                Bem-vindo, <strong><?= $_SESSION['usuario_nome']; ?></strong>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <h3 class="mb-4">Dashboard</h3>

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="card-box bg-blue">
                        <h6>Pacientes</h6>
                        <h2><?= $totalPacientes ?></h2>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-box bg-green">
                        <h6>Usuários</h6>
                        <h2><?= $totalUsuarios ?></h2>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-box bg-orange">
                        <h6>Consultas Hoje</h6>
                        <h2>0</h2>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card-box bg-red">
                        <h6>Contas a Receber</h6>
                        <h2>R$ 0,00</h2>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>