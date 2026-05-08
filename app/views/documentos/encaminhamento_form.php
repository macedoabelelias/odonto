<h4>Encaminhamento Odontológico</h4>

<div class="alert alert-info">
Paciente: <strong><?= $paciente['nome'] ?></strong>
</div>

<form method="POST" action="<?= BASE_URL ?>/documentos/encaminhamento/<?= $paciente['id'] ?>">

<div class="mb-3">
<label class="form-label">Especialidade / Profissional</label>

<select name="destino" class="form-control" required>

<option value="">Selecione a especialidade</option>

<option value="Endodontia">Endodontia</option>

<option value="Periodontia">Periodontia</option>

<option value="Ortodontia">Ortodontia</option>

<option value="Implantodontia">Implantodontia</option>

<option value="Prótese Dentária">Prótese Dentária</option>

<option value="Cirurgia Bucomaxilofacial">Cirurgia Bucomaxilofacial</option>

<option value="Odontopediatria">Odontopediatria</option>

<option value="Dentística Restauradora">Dentística Restauradora</option>

<option value="Disfunção Temporomandibular (DTM)">Disfunção Temporomandibular (DTM)</option>

<option value="Radiologia Odontológica">Radiologia Odontológica</option>

<option value="Patologia Oral">Patologia Oral</option>

</select>


<div class="mb-3">

<label class="form-label">Nome do especialista (opcional)</label>

<input
type="text"
name="especialista"
class="form-control"
placeholder="Ex: Dr. João Silva">

</div>


<div class="mb-3">

<label class="form-label">Clínica / Serviço (opcional)</label>

<input
type="text"
name="clinica"
class="form-control"
placeholder="Ex: Centro de Especialidades Odontológicas">

</div>


<div class="mb-3">

<label class="form-label">Motivo do encaminhamento</label>

<textarea
name="motivo"
class="form-control"
rows="3"
required></textarea>

</div>


<div class="mb-3">

<label class="form-label">Observações clínicas</label>

<textarea
name="observacoes"
class="form-control"
rows="3"></textarea>

</div>

<button class="btn btn-success">

Gerar Encaminhamento

</button>

</form>