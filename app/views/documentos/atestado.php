<?php

/* ===== LOGO BASE64 PARA DOMPDF ===== */

$logo = BASE_PATH . "/public/assets/img/logo9.jpg";

if(file_exists($logo)){

$type = pathinfo($logo, PATHINFO_EXTENSION);
$data = file_get_contents($logo);
$logoBase64 = "data:image/".$type.";base64,".base64_encode($data);

}else{

$logoBase64 = "";

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
font-size:20px;
font-weight:bold;
margin-bottom:30px;
}

.texto{
margin-left:45px;
margin-right:45px;
text-align:justify;
}

.assinatura{
margin-top:120px;
text-align:center;
}

</style>


<div class="header">

<table width="100%">

<tr>

<td width="20%">

<?php if($logoBase64): ?>

<img src="<?= $logoBase64 ?>" width="120" style="border-radius:10px;">

<?php endif; ?>

</td>

<td width="80%" style="text-align:right">

<b>ATESTADO ODONTOLÓGICO</b>

<br>

<?= date("d/m/Y") ?>

</td>

</tr>

</table>

</div>


<div class="titulo">

ATESTADO ODONTOLÓGICO

</div>


<p class="texto">

Eu, Dr(a). <b><?= $dentista['nome'] ?? 'Dentista' ?></b>, 
cirurgião-dentista inscrito no CRO 

<b><?= ($dentista['cro'] ?? '') ?>/<?= ($dentista['uf'] ?? '') ?></b>, 

atesto que o(a) paciente 

<b><?= $paciente['nome'] ?></b> 

esteve em atendimento odontológico sob meus cuidados profissionais.

</p>


<p class="texto">

Recomenda-se afastamento de suas atividades por 

<b><?= $dias ?> dia(s)</b>, 

a partir de 

<b><?= $data_inicio->format("d/m/Y") ?></b> 

até 

<b><?= $data_fim->format("d/m/Y") ?></b>.

</p>


<p class="texto">

Durante este período o paciente deverá seguir as orientações odontológicas.

</p>


<?php if(!empty($cid)): ?>

<p class="texto">

CID: <b><?= $cid ?></b>

</p>

<?php endif; ?>


<br><br>


<p class="texto">

Data: <?= date("d/m/Y") ?>

</p>


<div class="assinatura">

________________________________

<br>

Dr(a) <?= $dentista['nome'] ?? '' ?>

<br>

CRO <?= $dentista['registro_conselho'] ?? '' ?>

</div>