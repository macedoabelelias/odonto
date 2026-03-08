<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:14px;
}

h2{
    text-align:center;
}

.info{
    margin-bottom:10px;
}

.alerta{
    color:red;
    font-weight:bold;
}

</style>


<h2>Anamnese Odontológica</h2>

<p class="info"><strong>Paciente:</strong> <?= $paciente['nome'] ?? '' ?></p>

<hr>

<p><strong>Diabetes:</strong>
<?= !empty($anamnese['diabetes']) ? $anamnese['diabetes'] : 'Não informado' ?>
</p>

<p><strong>Hipertensão:</strong>
<?= !empty($anamnese['hipertensao']) ? $anamnese['hipertensao'] : 'Não informado' ?>
</p>

<p><strong>Problema cardíaco:</strong>
<?= !empty($anamnese['problema_cardiaco']) ? $anamnese['problema_cardiaco'] : 'Não informado' ?>
</p>

<p><strong>Alergias:</strong>
<?= !empty($anamnese['alergias']) ? $anamnese['alergias'] : 'Não informado' ?>
</p>

<p><strong>Medicamentos:</strong>
<?= !empty($anamnese['medicamentos']) ? $anamnese['medicamentos'] : 'Não informado' ?>
</p>

<p><strong>Observações:</strong><br>
<?= !empty($anamnese['observacoes']) ? $anamnese['observacoes'] : 'Nenhuma observação registrada' ?>
</p>


<br><br><br>

<table width="100%">
<tr>

<td>
_____________________________<br>
Paciente
</td>

<td style="text-align:right;">
_____________________________<br>
Dentista Responsável
<br>
CRO: __________
</td>

</tr>
</table>


<br>

<p style="text-align:center;">
Data: <?= date("d/m/Y") ?>
</p>