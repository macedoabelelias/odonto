<?php
require_once 'config/conexao.php';
$configSistema = $pdo->query("SELECT * FROM configuracoes LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


<div class="sidebar">

   <div class="logo-area text-center mb-4">

<?php if(!empty($configSistema['logo'])): ?>
    <img src="/odonto/uploads/<?= $configSistema['logo'] ?>" 
         class="logo-sidebar">
<?php else: ?>
    <h4><?= $configSistema['nome_clinica'] ?></h4>
<?php endif; ?>

</div>
    <hr>

    <a href="dashboard.php">Dashboard</a>
    <a href="pacientes.php">Pacientes</a>
    <a href="agendamentos.php">Agendamentos</a>
    <a href="consultas.php">Consultas</a>
    <a href="financeiro.php">Financeiro</a>
    <a href="relatorios.php">Relatórios</a>

    <hr style="border-color:rgba(255,255,255,0.3);">

    <a href="logout.php">Sair</a>

</div>

</body>
</html>