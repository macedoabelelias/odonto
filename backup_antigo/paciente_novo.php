<?php
require 'config/autenticarpainel.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Novo Paciente</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f4f6f9;">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">

            <h4 class="mb-4">Cadastrar Paciente</h4>

            <form method="POST" action="paciente_salvar.php">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Data de Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Endereço</label>
                        <input type="text" name="endereco" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Observações</label>
                        <textarea name="observacoes" class="form-control"></textarea>
                    </div>
                </div>

                <button class="btn btn-success">Salvar</button>
                <a href="pacientes.php" class="btn btn-secondary">Voltar</a>

            </form>

        </div>
    </div>
</div>

</body>
</html>