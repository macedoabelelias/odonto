<style>
body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 12px;
    color: #333;
}

.header {
    text-align: center;
    border-bottom: 2px solid #3b82f6;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.logo {
    width: 80px;
    margin-bottom: 5px;
}

.clinica {
    font-size: 14px;
    font-weight: bold;
}

.titulo {
    text-align: center;
    font-size: 16px;
    margin: 20px 0;
    font-weight: bold;
}

.bloco {
    margin-bottom: 12px;
    text-align: justify;
}

.bloco strong {
    display: block;
    margin-bottom: 4px;
}

.dados {
    background: #f1f5f9;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.assinaturas {
    margin-top: 50px;
    display: flex;
    justify-content: space-between;
}

.assinatura-box {
    width: 45%;
    text-align: center;
}

.linha {
    border-top: 1px solid #000;
    margin-top: 40px;
}

.logo {
    width: 150px;
    border-radius: 10px; /* 🔥 arredondado */
}

@page {
    margin: 20px 30px;
}

body {
    font-size: 11px;
}

</style>

<!-- CABEÇALHO -->
<div class="header">

    <!-- LOGO -->
    <?php
$logoPath = BASE_PATH . "/public/assets/img/logo9.jpg";

if(file_exists($logoPath)){
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoSrc = 'data:image/jpg;base64,' . $logoData;
}else{
    $logoSrc = '';
}
?>

<img src="<?= $logoSrc ?>" class="logo">

    <div class="clinica">
        Clínica Odontológica
    </div>

    <div style="font-size:11px;">
        CRO: XXXXX<br>
        Telefone: (00) 0000-0000
    </div>

</div>

<div class="titulo">
    CONTRATO DE PRESTAÇÃO DE SERVIÇOS ODONTOLÓGICOS
</div>

<!-- DADOS DO PACIENTE -->
<div class="dados">

    <strong>Paciente:</strong> <?= htmlspecialchars($paciente['nome']) ?><br>
    <strong>CPF:</strong> <?= htmlspecialchars($paciente['cpf'] ?? 'Não informado') ?><br>
    <strong>Telefone:</strong> <?= htmlspecialchars($paciente['telefone'] ?? '-') ?>

</div>

<!-- CLÁUSULAS -->

<div class="bloco">
<strong>1. OBJETO</strong><br>
Prestação de serviços odontológicos conforme o seguinte tratamento:
<br><br>
<?= nl2br(htmlspecialchars($tratamento)) ?>
</div>

<div class="bloco">
<strong>2. VALOR</strong><br>
O valor total do tratamento será de 
<strong>R$ <?= number_format((float)$valor, 2, ',', '.') ?></strong>,
conforme acordado entre as partes.
</div>

<div class="bloco">
<strong>3. RESPONSABILIDADE DO PACIENTE</strong><br>
O paciente compromete-se a comparecer às consultas, seguir orientações e manter
informações de saúde atualizadas.
</div>

<div class="bloco">
<strong>4. RESPONSABILIDADE DO PROFISSIONAL</strong><br>
O cirurgião-dentista executará os procedimentos conforme normas técnicas vigentes.
</div>

<div class="bloco">
<strong>5. RISCOS E LIMITAÇÕES</strong><br>
O paciente está ciente de que não há garantia absoluta de resultados,
devido à variabilidade biológica.
</div>

<div class="bloco">
<strong>6. FALTAS</strong><br>
Consultas não comparecidas poderão ser reagendadas conforme disponibilidade.
</div>

<div class="bloco">
<strong>7. ABANDONO DE TRATAMENTO</strong><br>
O abandono do tratamento isenta o profissional de responsabilidade sobre os resultados.
</div>

<div class="bloco">
<strong>8. FORO</strong><br>
Fica eleito o foro da comarca da clínica.
</div>

<br>

<p><strong>Data:</strong> <?= date('d/m/Y') ?></p>

<!-- ASSINATURAS -->
<table width="100%" style="margin-top:50px;">
<tr>

<td align="center" width="50%">
    <?php if(!empty($assinaturaPath)): ?>
        <img src="file://<?= BASE_PATH ?>/public/uploads/<?= $assinaturaPath ?>" width="140"><br>
    <?php else: ?>
        <div style="border-top:1px solid #000; width:200px; margin:auto;"></div>
    <?php endif; ?>
    Paciente
</td>

<td align="center" width="50%">
    <div style="border-top:1px solid #000; width:200px; margin:auto;"></div>
    Cirurgião-Dentista
</td>

</tr>
</table>

