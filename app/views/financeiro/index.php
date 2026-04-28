<h4 class="mb-4">📊 Gestão Financeira</h4>

<!-- 🔥 RESUMO -->
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3 border-start border-success border-4">
            <h6 class="text-muted">Recebido Hoje</h6>
            <h4 class="text-success mb-0">
                R$ <?= number_format($resumoReceber['hoje'] ?? 0,2,',','.') ?>
            </h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3 border-start border-danger border-4">
            <h6 class="text-muted">Pago Hoje</h6>
            <h4 class="text-danger mb-0">
                R$ <?= number_format($resumoPagar['hoje'] ?? 0,2,',','.') ?>
            </h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3 border-start border-warning border-4">
            <h6 class="text-muted">A Receber</h6>
            <h4 class="text-warning mb-0">
                R$ <?= number_format($resumoReceber['pendente'] ?? 0,2,',','.') ?>
            </h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3 border-start border-dark border-4">
            <h6 class="text-muted">A Pagar</h6>
            <h4 class="text-dark mb-0">
                R$ <?= number_format($resumoPagar['pendente'] ?? 0,2,',','.') ?>
            </h4>
        </div>
    </div>

</div>

<!-- 🔥 ATALHOS -->
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <a href="<?= BASE_URL ?>/contasReceber" class="text-decoration-none">
            <div class="card shadow-sm p-4 text-center h-100 hover-card">
                📥<br>
                <strong>Contas a Receber</strong>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="<?= BASE_URL ?>/contasPagar" class="text-decoration-none">
            <div class="card shadow-sm p-4 text-center h-100 hover-card">
                💸<br>
                <strong>Contas a Pagar</strong>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="<?= BASE_URL ?>/caixa" class="text-decoration-none">
            <div class="card shadow-sm p-4 text-center h-100 hover-card">
                🏦<br>
                <strong>Caixa</strong>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="<?= BASE_URL ?>/comissoes" class="text-decoration-none">
            <div class="card shadow-sm p-4 text-center h-100 hover-card">
                📊<br>
                <strong>Comissões</strong>
            </div>
        </a>
    </div>

</div>

<!-- 🔥 RELATÓRIO -->
<div class="card shadow-sm p-4 text-center">

    <h5 class="mb-3">📄 Relatórios</h5>

    <a href="<?= BASE_URL ?>/financeiro/relatorio" class="btn btn-dark px-4">
        Gerar Relatório Financeiro (PDF)
    </a>

</div>


<!-- 🔥 ESTILO EXTRA -->
<style>
.hover-card{
    transition: all 0.2s ease;
}

.hover-card:hover{
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}
</style>