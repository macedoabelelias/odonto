<form method="POST" action="anamnese/salvar/<?= $paciente['id'] ?>">

<input type="hidden" name="paciente_id" value="<?= $paciente['id'] ?>">

<h4 class="mb-4">🩺 Anamnese Odontológica</h4>

<div class="row">


<!-- SAÚDE GERAL -->

<div class="col-md-6">

<div class="card mb-3">
<div class="card-body">

<h5>Saúde Geral</h5>

<label>Diabetes</label>
<select name="diabetes" class="form-control mb-2">
<option value="nao" <?= ($anamnese['diabetes'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['diabetes'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Hipertensão</label>
<select name="hipertensao" class="form-control mb-2">
<option value="nao" <?= ($anamnese['hipertensao'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['hipertensao'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Problema cardíaco</label>
<select name="problema_cardiaco" class="form-control mb-2">
<option value="nao" <?= ($anamnese['problema_cardiaco'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['problema_cardiaco'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Possui marcapasso?</label>
<select name="marcapasso" class="form-control mb-2">
<option value="nao" <?= ($anamnese['marcapasso'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['marcapasso'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Radioterapia em cabeça ou pescoço?</label>
<select name="radioterapia" class="form-control mb-2">
<option value="nao" <?= ($anamnese['radioterapia'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['radioterapia'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Grávida</label>
<select name="gravida" class="form-control">
<option value="nao" <?= ($anamnese['gravida'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['gravida'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

</div>
</div>

</div>



<!-- ALERGIAS -->

<div class="col-md-6">

<div class="card mb-3">
<div class="card-body">

<h5>Alergias e Medicamentos</h5>

<label>Possui alergias?</label>
<select name="alergias" class="form-control mb-2">
<option value="nao" <?= ($anamnese['alergias'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['alergias'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Quais alergias?</label>
<input type="text"
name="quais_alergias"
class="form-control mb-2"
value="<?= $anamnese['quais_alergias'] ?? '' ?>">

<label>Uso de medicamentos contínuos?</label>
<select name="uso_medicamentos" class="form-control mb-2">
<option value="nao" <?= ($anamnese['uso_medicamentos'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['uso_medicamentos'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Quais medicamentos?</label>
<input type="text"
name="quais_medicamentos"
class="form-control mb-2"
value="<?= $anamnese['quais_medicamentos'] ?? '' ?>">

<label>Uso de anticoagulante?</label>
<select name="anticoagulante" class="form-control">
<option value="nao" <?= ($anamnese['anticoagulante'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['anticoagulante'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

</div>
</div>

</div>



<!-- HISTÓRICO MÉDICO -->

<div class="col-md-6">

<div class="card mb-3">
<div class="card-body">

<h5>Histórico Médico</h5>

<label>Já realizou cirurgias?</label>
<select name="cirurgias" class="form-control mb-2">
<option value="nao" <?= ($anamnese['cirurgias'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['cirurgias'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Quais cirurgias?</label>
<input type="text"
name="quais_cirurgias"
class="form-control mb-2"
value="<?= $anamnese['quais_cirurgias'] ?? '' ?>">

<label>Sangramento excessivo após cirurgia?</label>
<select name="sangramento_excessivo" class="form-control">
<option value="nao" <?= ($anamnese['sangramento_excessivo'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['sangramento_excessivo'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

</div>
</div>

</div>



<!-- HÁBITOS -->

<div class="col-md-6">

<div class="card mb-3">
<div class="card-body">

<h5>Hábitos</h5>

<label>Fuma?</label>
<select name="fuma" class="form-control mb-2">
<option value="nao" <?= ($anamnese['fuma'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['fuma'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Consome álcool?</label>
<select name="alcool" class="form-control mb-2">
<option value="nao" <?= ($anamnese['alcool'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['alcool'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Roer unhas?</label>
<select name="roer_unhas" class="form-control mb-2">
<option value="nao" <?= ($anamnese['roer_unhas'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['roer_unhas'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

<label>Morde objetos?</label>
<select name="morder_objetos" class="form-control">
<option value="nao" <?= ($anamnese['morder_objetos'] ?? '')=='nao'?'selected':'' ?>>Não</option>
<option value="sim" <?= ($anamnese['morder_objetos'] ?? '')=='sim'?'selected':'' ?>>Sim</option>
</select>

</div>
</div>

</div>



<!-- HIGIENE -->

<div class="col-md-6">

<div class="card mb-3">
<div class="card-body">

<h5>Higiene Bucal</h5>

<label>Escovações por dia</label>

<select name="escovacoes_dia" class="form-control mb-2">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4 ou mais</option>
</select>

<label>Usa fio dental?</label>
<select name="usa_fio_dental" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Sangramento gengival?</label>
<select name="sangramento_gengiva" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Mau hálito?</label>
<select name="mau_halito" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Sensibilidade dentária?</label>
<select name="sensibilidade" class="form-control">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

</div>
</div>

</div>



<!-- ATM -->

<div class="col-md-6">

<div class="card mb-3">
<div class="card-body">

<h5>ATM / Bruxismo</h5>

<label>Bruxismo?</label>
<select name="bruxismo" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Barulho na ATM?</label>
<select name="barulho_atm" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Dor na ATM?</label>
<select name="dor_atm" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Dificuldade de abrir a boca?</label>
<select name="dificuldade_abrir_boca" class="form-control">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

</div>
</div>

</div>



<!-- HISTÓRICO ODONTOLÓGICO -->

<div class="col-md-6">

<div class="card mb-3">
<div class="card-body">

<h5>Histórico Odontológico</h5>

<label>Última consulta</label>

<input type="date"
name="ultima_consulta"
class="form-control mb-2"
value="<?= $anamnese['ultima_consulta'] ?? '' ?>">

<label>Teve dor recente?</label>

<select name="dor_recente" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Nível de ansiedade (0-10)</label>

<input type="number"
name="nivel_ansiedade"
min="0"
max="10"
class="form-control"
value="<?= $anamnese['nivel_ansiedade'] ?? '' ?>">

</div>
</div>

</div>



<!-- OBSERVAÇÕES -->

<div class="col-md-12">

<div class="card mb-3">
<div class="card-body">

<h5>Observações</h5>

<textarea name="observacoes" class="form-control" rows="4"><?= $anamnese['observacoes'] ?? '' ?></textarea>

</div>
</div>

</div>

</div>



<div class="d-flex justify-content-between mt-3">

<a href="<?= BASE_URL ?>/anamnese/pdf/<?= $paciente['id'] ?>"
class="btn btn-danger">

📄 Gerar PDF

</a>

<div>

<button class="btn btn-success">
Salvar Anamnese
</button>

<a href="<?= BASE_URL ?>/prontuarios/index/<?= $paciente['id'] ?>"
class="btn btn-secondary">

Voltar

</a>

</div>

</div>

</form>
