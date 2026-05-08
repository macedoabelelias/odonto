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
padding-bottom:10px;
margin-bottom:30px;
}

.titulo{
text-align:center;
font-size:22px;
font-weight:bold;
margin-bottom:25px;
}

.campo{
margin-bottom:20px;
}

.linha{
border-bottom:1px solid #000;
height:25px;
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

<b>Receituário Odontológico</b>

<br>

<?= date("d/m/Y") ?>

</td>

</tr>

</table>

</div>


<div class="titulo">

RECEITA ODONTOLÓGICA

</div>

<div class="campo">

Paciente:
<strong><?= $paciente['nome'] ?></strong>

</div>


<div class="campo">

Medicamento:
<br>
<strong><?= $medicamento ?></strong>

</div>


<div class="campo">

Dosagem / Posologia:
<br>
<?= $posologia ?>

</div>


<div class="campo">

Duração do tratamento:
<br>
<?= $duracao ?>

</div>


<div class="campo">

Observações:
<br>
<?= $observacao ?>

</div>


<br><br>


Data:

<?= date("d/m/Y") ?>


<div class="assinatura">

________________________________

<br>

Dr(a). <?= $dentista['nome'] ?? 'Dentista' ?>

<br>

Cirurgião Dentista

<br>

CRO <?= $dentista['registro_conselho'] ?? '' ?>

</div>