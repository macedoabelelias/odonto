<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

$id = $_GET['id'] ?? null;

$sql = $pdo->prepare("SELECT * FROM pacientes WHERE id=?");
$sql->execute([$id]);
$paciente = $sql->fetch(PDO::FETCH_ASSOC);

include 'layout/header.php';
include 'layout/sidebar.php';
include 'layout/navbar.php';
?>

<h3>Prontuário de <?= htmlspecialchars($paciente['nome']) ?></h3>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <p><strong>CPF:</strong> <?= $paciente['cpf'] ?></p>
        <p><strong>Telefone:</strong> <?= $paciente['telefone'] ?></p>
        <p><strong>Email:</strong> <?= $paciente['email'] ?></p>
        <p><strong>Observações:</strong> <?= $paciente['observacoes'] ?></p>
    </div>
</div>

<?php include 'layout/footer.php'; ?>