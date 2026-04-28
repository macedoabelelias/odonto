<h4>📄 Gerar Atestado</h4>

<div class="alert alert-info">

Paciente: <b><?= $paciente['nome'] ?></b>

</div>

<form method="GET" action="<?= BASE_URL ?>/documentos/atestado/<?= $paciente['id'] ?>">

<div class="mb-3">

<label class="form-label">Dias de afastamento</label>

<input type="number"
name="dias"
class="form-control"
value="1"
min="1">

</div>

<div class="mb-3">

<select name="cid" class="form-control">

<option value="">Sem CID</option>

<optgroup label="Cáries">

<option value="K02.0 - Cárie limitada ao esmalte">K02.0 - Cárie limitada ao esmalte</option>

<option value="K02.1 - Cárie da dentina">K02.1 - Cárie da dentina</option>

<option value="K02.2 - Cárie do cemento">K02.2 - Cárie do cemento</option>

</optgroup>


<optgroup label="Polpa dentária">

<option value="K04.0 - Pulpite">K04.0 - Pulpite</option>

<option value="K04.1 - Necrose da polpa">K04.1 - Necrose da polpa</option>

<option value="K04.7 - Abscesso periapical">K04.7 - Abscesso periapical</option>

</optgroup>


<optgroup label="Periodontia">

<option value="K05.0 - Gengivite aguda">K05.0 - Gengivite aguda</option>

<option value="K05.1 - Gengivite crônica">K05.1 - Gengivite crônica</option>

<option value="K05.3 - Periodontite crônica">K05.3 - Periodontite crônica</option>

</optgroup>


<optgroup label="Outras alterações dentárias">

<option value="K08.1 - Perda de dentes">K08.1 - Perda de dentes</option>

<option value="K08.3 - Raiz dentária retida">K08.3 - Raiz dentária retida</option>

<option value="K08.8 - Outras afecções dentárias">K08.8 - Outras afecções dentárias</option>

</optgroup>

</select>

</div>



<button class="btn btn-primary">

Gerar Atestado

</button>

</form>