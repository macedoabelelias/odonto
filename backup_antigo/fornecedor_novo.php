<?php
require_once("layout/header.php");
require_once("layout/navbar.php");
require_once("layout/sidebar.php");
?>

<div class="container mt-4">
    <h3>Novo Fornecedor</h3>

    <form method="POST" action="fornecedor_salvar.php">
        
        <div class="row">
            <div class="col-md-6 mb-2">
                <label>Nome *</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="col-md-6 mb-2">
                <label>CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>Telefone</label>
                <input type="text" name="telefone" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>

            <div class="col-md-8 mb-2">
                <label>Endereço</label>
                <input type="text" name="endereco" class="form-control">
            </div>

            <div class="col-md-3 mb-2">
                <label>Cidade</label>
                <input type="text" name="cidade" class="form-control">
            </div>

            <div class="col-md-1 mb-2">
                <label>UF</label>
                <input type="text" name="estado" maxlength="2" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-success">
            Salvar
        </button>

        <a href="fornecedores.php" class="btn btn-secondary">
            Voltar
        </a>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$('#cnpj').mask('00.000.000/0000-00');
</script>

<?php require_once("layout/footer.php"); ?>