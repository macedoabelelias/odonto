<?php

/* ===== LOGO BASE64 ===== */

$logo = BASE_PATH."/public/assets/img/logo9.jpg";

if(file_exists($logo)){
$type = pathinfo($logo, PATHINFO_EXTENSION);
$data = file_get_contents($logo);
$logoBase64 = "data:image/".$type.";base64,".base64_encode($data);
}else{
$logoBase64="";
}

?>

<style>

body{
font-family: DejaVu Sans;
font-size:14px;
}

.header{
border-bottom:1px solid #000;
margin-bottom:30px;
padding-bottom:10px;
}

.titulo{
text-align:center;
font-size:22px;
font-weight:bold;
margin-bottom:25px;
}

.texto{
margin-left:45px;
margin-right:45px;
text-align:justify;
margin-bottom:15px;
}

.assinatura{
margin-top:80px;
text-align:center;
}

</style>


<div class="header">

<table width="100%">
<tr>

<td width="20%">
<?php if($logoBase64): ?>
<img src="<?= $logoBase64 ?>" width="110" style="border-radius:10px;">
<?php endif; ?>
</td>

<td width="80%" style="text-align:right">
Encaminhamento Odontológico
<br>
<?= date("d/m/Y") ?>
</td>

</tr>
</table>

</div>


<div class="titulo">
ENCAMINHAMENTO ODONTOLÓGICO
</div>


<!-- TEXTO PRINCIPAL -->
<p class="texto">

Encaminho o(a) paciente

<strong><?= $paciente['nome'] ?></strong>

para avaliação na especialidade de

<strong><?= $destino ?></strong>

<?php if(!empty($especialista)): ?>
com <strong><?= $especialista ?></strong>
<?php endif; ?>

<?php if(!empty($clinica)): ?>
na clínica <strong><?= $clinica ?></strong>
<?php endif; ?>.

</p>


<p class="texto">
<b>Motivo do encaminhamento:</b>
<br><br>
<?= $motivo ?>
</p>


<?php if(!empty($observacoes)): ?>
<p class="texto">
<b>Observações clínicas:</b>
<br><br>
<?= $observacoes ?>
</p>
<?php endif; ?>


<p class="texto">
Franca, <?= date("d/m/Y") ?>.
</p>


<div class="assinatura">

________________________________
<br>

Dr(a). <?= $dentista['nome'] ?? '' ?>
<br>

Cirurgião Dentista
<br>

CRO <?= $dentista['registro_conselho'] ?? '' ?>

</div>