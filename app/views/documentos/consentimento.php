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
Termo de Consentimento
<br>
<?= date("d/m/Y") ?>
</td>

</tr>
</table>

</div>


<div class="titulo">
TERMO DE CONSENTIMENTO
</div>


<p class="texto">

Eu, <strong><?= $paciente['nome'] ?></strong>, declaro que fui devidamente informado(a) sobre o procedimento odontológico proposto.

</p>


<?php if(!empty($procedimento)): ?>
<p class="texto">

<b>Procedimento:</b>
<br><br>

<?= $procedimento ?>

</p>
<?php endif; ?>


<?php if(!empty($observacoes)): ?>
<p class="texto">

<b>Observações:</b>
<br><br>

<?= $observacoes ?>

</p>
<?php endif; ?>


<p class="texto">

Declaro estar ciente dos riscos, benefícios e alternativas do tratamento, autorizando sua realização.

</p>


<p class="texto">
Franca, <?= date("d/m/Y") ?>.
</p>


<div class="assinatura">

________________________________
<br>

<?= $paciente['nome'] ?>

<br><br><br>

________________________________
<br>

Dr(a). <?= $dentista['nome'] ?? '' ?>

<br>

CRO <?= $dentista['registro_conselho'] ?? '' ?>

</div>