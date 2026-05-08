<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Orientação ao Paciente</title>

<style>

body{
    font-family:Arial, sans-serif;
    margin:40px auto;
    max-width:900px;
    color:#333;
}

h2{
    text-align:center;
    margin-bottom:10px;
}

hr{
    margin:20px 0;
}

.topo{
    display:flex;
    justify-content:space-between;
    gap:20px;
}

.topo div{
    width:33%;
}

.orientacao-box{
    border:1px solid #eee;
    border-radius:10px;
    padding:20px;
    margin-top:20px;
}

.orientacao-texto{
    line-height:1.8;
    font-size:15px;
    margin-top:15px;
    white-space:pre-line;
}

.imagem-orientacao{
    width:auto;
    max-width:70%;
    max-height:250px;
    display:block;
    margin:20px auto;
    border-radius:12px;
    border:1px solid #ddd;
    box-shadow:0 2px 6px rgba(0,0,0,0.08);
}

.assinaturas{
    display:flex;
    justify-content:space-between;
    margin-top:80px;
    gap:40px;
}

.assinatura-item{
    width:45%;
    text-align:center;
}

.linha-assinatura{
    width:80%;
    margin:0 auto 8px auto;
    border-bottom:2px solid #444;
    height:30px;
}

.assinatura-item p{
    font-size:12px;
    color:#555;
}

.botoes button{
    padding:6px 10px;
    margin-left:5px;
    border:none;
    border-radius:4px;
    cursor:pointer;
}

.btn-print{
    background:#2563eb;
    color:#fff;
}

.btn-close{
    background:#333;
    color:#fff;
}

@media print{

    .botoes{
        display:none;
    }

    body{
        margin:20px;
    }

}

</style>

</head>
<body>

<!-- 🔥 TOPO -->
<div style="text-align:center; margin-bottom:10px;">

    <img
        src="<?= BASE_URL ?>/assets/img/logo9.png"
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

<!-- 🔥 BOTÕES -->
<div class="botoes">

    <button
        class="btn-print"
        onclick="window.print()">

        🖨️ Imprimir

    </button>

    <button
        class="btn-close"
        onclick="window.close()">

        ❌ Fechar

    </button>

</div>

<h2>
    🩺 Orientação ao Paciente
</h2>

<hr>

<!-- 🔥 DADOS -->
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

<!-- 🔥 ORIENTAÇÃO -->
<div class="orientacao-box">

    <h3>

        <?= htmlspecialchars($orientacao['titulo'] ?? '') ?>

    </h3>

<?php if(!empty($orientacao['imagem'])): ?>

    <img
        src="<?= BASE_URL ?>/uploads/orientacoes/<?= $orientacao['imagem'] ?>"
        class="imagem-orientacao">

<?php endif; ?>

<!-- 🔥 ANEXOS -->
<?php if(!empty($arquivos)): ?>

    <hr>

    <h4>
        📎 Anexos Clínicos
    </h4>

    <div
        style="
            display:flex;
            flex-wrap:wrap;
            gap:15px;
            margin-top:15px;
        ">

        <?php foreach($arquivos as $arq): ?>

            <?php
            $ext = strtolower(
                pathinfo(
                    $arq['arquivo'],
                    PATHINFO_EXTENSION
                )
            );
            ?>

            <?php if(in_array($ext, ['jpg','jpeg','png','webp'])): ?>

                <div
                    style="
                        width:180px;
                        text-align:center;
                    ">

                    <img
                        src="<?= BASE_URL ?>/uploads/orientacoes/<?= $arq['arquivo'] ?>"
                        style="
                            width:100%;
                            height:140px;
                            object-fit:contain;
                            border:1px solid #ddd;
                            border-radius:10px;
                            padding:5px;
                            background:#fff;
                        ">

                </div>

            <?php endif; ?>

        <?php endforeach; ?>

    </div>

<?php endif; ?>    

    <div class="orientacao-texto">

        <?= nl2br(htmlspecialchars($orientacao['texto'] ?? '')) ?>

    </div>

</div>

<!-- 🔥 ASSINATURAS -->
<div class="assinaturas">

    <div class="assinatura-item">

        <div class="linha-assinatura"></div>

        <p>
            Assinatura do Paciente / Responsável
        </p>

    </div>

    <div class="assinatura-item">

        <div class="linha-assinatura"></div>

        <p>
            Assinatura do Profissional
        </p>

    </div>

</div>

</body>
</html>