<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Prontuário do Paciente</title>

<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 30px auto;
    max-width: 900px;
    color: #333;
    background: #fff;
}

/* TÍTULOS */
h2 {
    text-align: center;
    margin-bottom: 5px;
    font-weight: 600;
}

h3 {
    margin-top: 25px;
    border-left: 4px solid #0d6efd;
    padding-left: 10px;
    font-size: 16px;
    font-weight: 600;
}

/* TOPO */
.topo {
    text-align: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.topo img {
    height: 70px;
    margin-bottom: 5px;
}

/* LINHAS DE DADOS */
.linha {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
}

/* CARDS (ESTILO PREMIUM) */
.card {
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 10px;
    background: #fafafa;
}

/* RUBRICA */
.rubrica {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
}

.rubrica-linha {
    width: 60%;
    border-bottom: 1px dashed #999;
    height: 18px;
}

.rubrica small {
    font-size: 10px;
    color: #888;
}

/* DATA */
.data {
    font-size: 11px;
    color: #666;
}

/* TOTAL */
.total {
    text-align: right;
    font-weight: bold;
    margin-top: 10px;
    font-size: 15px;
}

/* ASSINATURAS */
.assinaturas {
    display: flex;
    justify-content: space-between;
    margin-top: 60px;
    gap: 40px;
}

.assinatura-item {
    width: 45%;
    text-align: center;
}

.linha-assinatura {
    width: 80%;
    margin: 0 auto 5px auto;
    border-bottom: 1px solid #000;
}

/* RODAPÉ */
.rodape {
    margin-top: 40px;
    font-size: 11px;
    text-align: center;
    color: #999;
}

/* BOTÕES */
.botoes {
    position: fixed;
    top: 10px;
    right: 10px;
}

@media print {
    .botoes {
        display: none;
    }
}
</style>

</head>
<body>

<!-- BOTÕES -->
<div class="botoes">
    <button onclick="window.print()">🖨️ Imprimir</button>
    <button onclick="window.close()">❌ Fechar</button>
</div>

<!-- LOGO -->
<div class="topo">

    <img src="<?= BASE_URL ?>/assets/img/logo9.png"
     style="height:80px; border-radius:12px; padding:5px; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.15);">

    <div style="font-size:18px; font-weight:bold;">
        AM Systems Odontologia
    </div>

    <div style="font-size:13px; color:#666;">
        Clínica Odontológica
    </div>

</div>

<h2>Prontuário do Paciente</h2>

<hr>

<!-- DADOS -->
<div style="display:flex; justify-content:space-between;">
    <div>
        <strong>Paciente:</strong><br>
        <?= htmlspecialchars($paciente['nome'] ?? '') ?>
    </div>

    <div>
        <strong>CPF:</strong><br>
        <?= htmlspecialchars($paciente['cpf'] ?? '') ?>
    </div>

    <div>
        <strong>Data:</strong><br>
        <?= date('d/m/Y') ?>
    </div>
</div>

<hr>

<!-- PROFISSIONAL -->
<div style="margin-bottom:15px;">
    <p><strong>Dentista:</strong> <?= htmlspecialchars($profissional['nome'] ?? '') ?></p>
    <p><strong>CRO:</strong> <?= htmlspecialchars($profissional['cro'] ?? '') ?></p>
</div>

<hr>

<!-- ODONTOGRAMA -->
<h3>Odontograma</h3>

<div style="text-align:center; margin-bottom:20px;">
    <img id="imgOdonto" style="width:100%; max-width:600px;">
</div>

<hr>

<!-- EVOLUÇÃO DO TRATAMENTO -->
<h3>Evolução do Tratamento</h3>

<?php $total = 0; ?>

<?php foreach(($orcamento['itens'] ?? []) as $item): ?>

<?php
$status = strtolower($item['status'] ?? '');
if($status === 'existente') continue;

$valor = floatval($item['valor'] ?? 0);

// Só soma se realizado
if($status === 'realizado'){
    $total += $valor;
}

$nome =
    $item['nome']
    ?? $item['procedimento_nome']
    ?? $item['procedimento']
    ?? 'Procedimento';

$dente = $item['dente'] ?? '';
?>

<div class="card">

    <!-- LINHA PRINCIPAL (NOME + VALOR) -->
    <div class="linha">

        <span>
            <strong>
                <?= htmlspecialchars($nome) ?>
                <?= $dente ? " - Dente {$dente}" : "" ?>
            </strong>
        </span>

        <?php if($valor > 0): ?>
            <span style="font-weight:600;">
                R$ <?= number_format($valor, 2, ',', '.') ?>
            </span>
        <?php endif; ?>

    </div>

    <!-- STATUS -->
    <div style="color:#0d6efd; font-size:13px; margin-top:2px;">
        <?= ucfirst($status) ?>
    </div>

    <!-- RUBRICA + DATA -->
    <div class="rubrica">
        <div>
            <div class="rubrica-linha"></div>
            <small>Rubrica do paciente</small>
        </div>

        <div class="data">
            <?= date('d/m/Y H:i') ?>
        </div>
    </div>

</div>

<?php endforeach; ?>

<!-- TOTAL -->
<?php if($total > 0): ?>
    <div class="total">
        Total do tratamento realizado: 
        R$ <?= number_format($total, 2, ',', '.') ?>
    </div>
<?php endif; ?>

<hr>

<!-- ASSINATURAS -->
<div class="assinaturas">

    <div class="assinatura-item">
        <div class="linha-assinatura"></div>
        <p>Assinatura do Paciente</p>
    </div>

    <div class="assinatura-item">
        <div class="linha-assinatura"></div>
        <p>Assinatura do Profissional</p>
    </div>

</div>

<!-- RODAPÉ -->
<div class="rodape">
    Documento gerado em <?= date('d/m/Y H:i') ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
window.onload = function(){
    setTimeout(() => {

        let odonto = window.opener?.document.getElementById("odontograma");

        if(odonto){
            html2canvas(odonto, { scale: 2 }).then(canvas => {
                document.getElementById("imgOdonto").src = canvas.toDataURL();
            });
        }

    }, 800);
}
</script>

</body>
</html>