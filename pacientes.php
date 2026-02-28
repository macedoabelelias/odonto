<?php
require 'config/autenticarpainel.php';
require 'config/conexao.php';

$sql = $pdo->query("SELECT * FROM pacientes ORDER BY id DESC");
$pacientes = $sql->fetchAll(PDO::FETCH_ASSOC);

include 'layout/header.php';
include 'layout/sidebar.php';
include 'layout/navbar.php';
?>

<h3 class="mb-4">Pacientes</h3>

<div class="card shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPaciente">
                Novo Paciente
            </button>
        </div>

        <table id="tabelaPacientes" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Idade</th>
                    <th>Email</th>
                    <th width="260">Ações</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach($pacientes as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= htmlspecialchars($p['telefone']) ?></td>
                    <td>
                        <?php
                        if($p['data_nascimento']){
                            $idade = (new DateTime($p['data_nascimento']))->diff(new DateTime())->y;
                            echo $idade . " anos";
                        } else {
                            echo "-";
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($p['email']) ?></td>
                    <td>

                        <!-- EDITAR -->
                        <button 
                            class="btn btn-sm btn-warning btn-editar"
                            data-id="<?= $p['id'] ?>"
                            data-nome="<?= htmlspecialchars($p['nome']) ?>"
                            data-cpf="<?= $p['cpf'] ?>"
                            data-data="<?= $p['data_nascimento'] ?>"
                            data-telefone="<?= $p['telefone'] ?>"
                            data-email="<?= $p['email'] ?>"
                            data-cep="<?= $p['cep'] ?>"
                            data-endereco="<?= $p['endereco'] ?>"
                            data-bairro="<?= $p['bairro'] ?>"
                            data-cidade="<?= $p['cidade'] ?>"
                            data-estado="<?= $p['estado'] ?>"
                            data-observacoes="<?= htmlspecialchars($p['observacoes']) ?>"
                        >
                            Editar
                        </button>

                        <!-- PRONTUÁRIO -->
                        <a href="prontuario.php?id=<?= $p['id'] ?>" 
                           class="btn btn-sm btn-info">
                           Prontuário
                        </a>

                        <!-- EXCLUIR -->
                        <a href="paciente_excluir.php?id=<?= $p['id'] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Deseja excluir este paciente?')">
                           Excluir
                        </a>

                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>

<!-- ================= MODAL PACIENTE ================= -->
<div class="modal fade" id="modalPaciente" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 shadow">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="tituloModal">Cadastrar Paciente</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="paciente_salvar.php">

        <input type="hidden" name="id" id="paciente_id">

        <div class="modal-body">

          <div class="row g-3">

            <div class="col-md-6">
              <label>Nome</label>
              <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label>CPF</label>
              <input type="text" name="cpf" id="cpf" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Data de Nascimento</label>
              <input type="date" name="data_nascimento" id="data_nascimento" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Idade</label>
              <input type="text" id="idade" class="form-control" readonly>
            </div>

            <div class="col-md-6">
              <label>Telefone</label>
              <input type="text" name="telefone" id="telefone" class="form-control">
            </div>

            <div class="col-md-6">
              <label>Email</label>
              <input type="email" name="email" class="form-control">
            </div>

            <div class="col-md-4">
              <label>CEP</label>
              <input type="text" name="cep" id="cep" class="form-control">
            </div>

            <div class="col-md-8">
              <label>Endereço</label>
              <input type="text" name="endereco" id="endereco" class="form-control">
            </div>

            <div class="col-md-4">
              <label>Bairro</label>
              <input type="text" name="bairro" id="bairro" class="form-control">
            </div>

            <div class="col-md-4">
              <label>Cidade</label>
              <input type="text" name="cidade" id="cidade" class="form-control">
            </div>

            <div class="col-md-4">
              <label>Estado</label>
              <input type="text" name="estado" id="estado" class="form-control">
            </div>

            <div class="col-md-12">
              <label>Observações</label>
              <textarea name="observacoes" class="form-control"></textarea>
            </div>

          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>

      </form>

    </div>
  </div>
</div>

<script>
$(document).on('click', '.btn-editar', function(){

    $('#tituloModal').text('Editar Paciente');

    $('#paciente_id').val($(this).data('id'));
    $('input[name="nome"]').val($(this).data('nome'));
    $('#cpf').val($(this).data('cpf'));
    $('#data_nascimento').val($(this).data('data'));
    $('#telefone').val($(this).data('telefone'));
    $('input[name="email"]').val($(this).data('email'));
    $('#cep').val($(this).data('cep'));
    $('#endereco').val($(this).data('endereco'));
    $('#bairro').val($(this).data('bairro'));
    $('#cidade').val($(this).data('cidade'));
    $('#estado').val($(this).data('estado'));
    $('textarea[name="observacoes"]').val($(this).data('observacoes'));

    var nascimento = new Date($(this).data('data'));
    var hoje = new Date();
    var idade = hoje.getFullYear() - nascimento.getFullYear();
    $('#idade').val(idade + " anos");

    $('#modalPaciente').modal('show');
});
</script>

<?php include 'layout/footer.php'; ?>