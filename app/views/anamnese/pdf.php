<style>

body{
font-family: DejaVu Sans, sans-serif;
font-size:12px;
}

h2{
text-align:center;
margin-bottom:10px;
}

.section{
margin-top:15px;
}

.label{
font-weight:bold;
}

hr{
margin-top:15px;
margin-bottom:15px;
}

.assinatura{
margin-top:60px;
text-align:center;
}

</style>


<h2>Anamnese Odontológica</h2>

<hr>

<div>

<span class="label">Paciente:</span>
<?= htmlspecialchars($paciente['nome']) ?>

<br>

<span class="label">Telefone:</span>
<?= htmlspecialchars($paciente['telefone']) ?>

<br>

<span class="label">CPF:</span>
<?= htmlspecialchars($paciente['cpf']) ?>

<br>

<span class="label">Data de nascimento:</span>
<?= date("d/m/Y",strtotime($paciente['data_nascimento'])) ?>

</div>

<hr>


<div class="section">

<h3>Saúde Geral</h3>

Diabetes: <?= $anamnese['diabetes'] ?><br>

Hipertensão: <?= $anamnese['hipertensao'] ?><br>

Problema cardíaco: <?= $anamnese['problema_cardiaco'] ?><br>

Gravidez: <?= $anamnese['gravidez'] ?><br>

Semanas: <?= $anamnese['quantas_semanas'] ?><br>

Outras informações:<br>

<?= nl2br($anamnese['outras_informacoes']) ?>

</div>


<div class="section">

<h3>Medicamentos</h3>

Uso de medicamentos: <?= $anamnese['uso_medicamentos'] ?><br>

Quais medicamentos:<br>

<?= nl2br($anamnese['quais_medicamentos']) ?>

</div>


<div class="section">

<h3>Alergias</h3>

Possui alergia: <?= $anamnese['alergias'] ?><br>

<?= nl2br($anamnese['quais_alergias']) ?>

</div>


<div class="section">

<h3>Cirurgias</h3>

Já fez cirurgia: <?= $anamnese['cirurgias'] ?><br>

<?= nl2br($anamnese['quais_cirurgias']) ?>

</div>


<div class="section">

<h3>Higiene Bucal</h3>

Escovação por dia: <?= $anamnese['escovacao_dia'] ?><br>

Uso de fio dental: <?= $anamnese['uso_fio_dental'] ?><br>

Uso de enxaguante: <?= $anamnese['uso_enxaguante'] ?>

</div>


<div class="section">

<h3>Sintomas</h3>

Dor em dente: <?= $anamnese['dor_dente'] ?><br>

Dor ao mastigar: <?= $anamnese['dor_mastigar'] ?><br>

Sensibilidade: <?= $anamnese['sensibilidade'] ?><br>

Sangramento gengival: <?= $anamnese['sangramento_gengiva'] ?>

</div>


<div class="section">

<h3>ATM</h3>

Dor ao abrir boca: <?= $anamnese['dor_abrir_boca'] ?><br>

Estalos na mandíbula: <?= $anamnese['estalo_mandibula'] ?>

</div>


<div class="section">

<h3>Observações Clínicas</h3>

<?= nl2br($anamnese['observacoes']) ?>

</div>


<div class="assinatura">

<br><br>

____________________________________  
Assinatura do paciente

<br><br>

Data: ____ / ____ / ______

</div>