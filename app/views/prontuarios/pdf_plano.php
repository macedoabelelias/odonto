<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Plano de Tratamento</title>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 40px auto;
    max-width: 900px;
    color: #333;
}

/* 🔥 TÍTULO */
h2 {
    text-align: center;
    margin-bottom: 10px;
}

/* 🔥 LINHAS */
hr {
    margin: 20px 0;
}

/* 🔥 TOPO */
.topo {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.topo div {
    width: 33%;
}

/* 🔥 PROCEDIMENTOS */
.linha {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #eee;
    padding: 6px 0;
    font-size: 14px;
}

/* 🔥 TOTAL */
.total {
    text-align: right;
    font-weight: bold;
    margin-top: 10px;
    font-size: 16px;
}

/* 🔥 ASSINATURAS */
.assinaturas {
    display: flex;
    justify-content: space-between;
    margin-top: 80px;
    gap: 40px;
}

.assinatura-item {
    width: 45%;
    text-align: center;
}

.linha-assinatura {
    width: 80%;
    margin: 0 auto 8px auto;
    border-bottom: 2px solid #444;
    height: 30px;
}

.assinatura-item p {
    font-size: 12px;
    color: #555;
}

.botoes button {
    padding: 6px 10px;
    margin-left: 5px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-print {
    background: #2563eb;
    color: #fff;
}

.btn-close {
    background: #333;
    color: #fff;
}

/* 🔥 NÃO PRINTAR BOTÕES */
@media print {
    .botoes {
        display: none;
    }

    body {
        margin: 20px;
    }
}
</style>

</head>
<body>

<div style="text-align:center; margin-bottom:10px;">

    <img src="<?= BASE_URL ?>/assets/img/logo9.png" 
        <img src="<?= BASE_URL ?>/assets/img/logo.png" 
     style="
        height:80px;
        border-radius:12px;
        padding:5px;
        background:#fff;
        box-shadow:0 2px 6px rgba(0,0,0,0.15);
     ">

    <div style="font-size:18px; font-weight:bold;">
        AM Systems Odontologia
    </div>

    <div style="font-size:12px; color:#666;">
        Clínica Odontológica
    </div>

</div>
<hr><hr>

<!-- BOTÕES -->
<div class="botoes">
    <button class="btn-print" onclick="window.print()">🖨️ Imprimir</button>
    <button class="btn-close" onclick="window.close()">❌ Fechar</button>
</div>

<h2>Plano de Tratamento Odontológico</h2>

<hr>

<div class="topo">
    <div>
        <strong>Paciente:</strong><br>
        <?= htmlspecialchars($paciente['nome'] ?? '') ?>
    </div>

    <div>
        <strong>CPF:</strong><br>
        <?= htmlspecialchars($paciente['cpf'] ?? '') ?>
    </div>

    <div style="text-align:right;">
        <strong>Data:</strong><br>
        <?= date('d/m/Y') ?>
    </div>
</div>

<hr>

<hr>

<h3>Odontograma</h3>

<div style="text-align:center; margin:20px 0;">
    <img id="imgOdonto" style="width:100%; max-width:600px;">
</div>

<hr>

<h3>Procedimentos</h3>

<?php $total = 0; ?>

<?php if(!empty($orcamento['itens'])): ?>

    <?php foreach($orcamento['itens'] as $item): ?>

        <?php
        $status = strtolower($item['status'] ?? '');
        if($status === 'existente') continue;

        $valor = floatval($item['valor'] ?? 0);
        $qtd = 1;

        $subtotal = $valor * $qtd;
        $total += $subtotal;

        // 🔥 NOME CORRETO (robusto)
        $nome =
            $item['procedimento']
            ?? $item['nome']
            ?? $item['descricao']
            ?? 'Procedimento';

        $dente = $item['dente'] ?? '';

        // 🔥 ÍCONE (com fallback)
        $icone = $item['icone'] ?? 'default.png';
        ?>

        <div class="card">

            <div class="linha">
                <span>

                    <!-- 🔥 ÍCONE COLORIDO -->
                    <img src="<?= BASE_URL ?>/assets/img/procedimentos/<?= $icone ?>"
                         style="width:18px; height:18px; margin-right:6px; vertical-align:middle;">

                    <?= htmlspecialchars($nome) ?>
                    <?= $dente ? " - Dente {$dente}" : "" ?>
                    (Qtd: <?= $qtd ?>)
                </span>

                <span>
                    R$ <?= number_format($subtotal, 2, ',', '.') ?>
                </span>
            </div>

        </div>

    <?php endforeach; ?>

    <!-- 🔥 TOTAL -->
    <div class="total">
        Total: R$ <?= number_format($total, 2, ',', '.') ?>
    </div>

<?php else: ?>

    <p style="color:#999;">Nenhum procedimento encontrado.</p>

<?php endif; ?>


<!-- ASSINATURAS -->
<div class="assinaturas">

    <div class="assinatura-item">
        <div class="linha-assinatura"></div>
        <p>Assinatura do Paciente / Responsável</p>
    </div>

    <div class="assinatura-item">
        <div class="linha-assinatura"></div>
        <p>Assinatura do Profissional</p>
    </div>

</div>

<hr>



<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
window.onload = function(){

    setTimeout(() => {

        try {
            let odonto = window.opener.document.getElementById("odontograma");

            if(!odonto){
                console.warn("Odontograma não encontrado");
                return;
            }

            html2canvas(odonto, { scale: 2 }).then(canvas => {
                document.getElementById("imgOdonto").src = canvas.toDataURL("image/png");
            });

        } catch(e){
            console.error("Erro odontograma:", e);
        }

    }, 1000); // 🔥 mais tempo = mais confiável

};
</script>

</body>
</html>