<h4 class="mb-4">🩺 Anamnese do Paciente</h4>

<div class="alert alert-info">

<strong>Paciente:</strong> <?= htmlspecialchars($paciente['nome']) ?>

<br>

<strong>Telefone:</strong> <?= htmlspecialchars($paciente['telefone'] ?? '') ?>

<br>

<strong>CPF:</strong> <?= htmlspecialchars($paciente['cpf'] ?? '') ?>

<br>

<strong>Data de nascimento:</strong>
<?= !empty($paciente['data_nascimento']) ? date("d/m/Y",strtotime($paciente['data_nascimento'])) : '' ?>

</div>


<form method="POST" action="<?= BASE_URL ?>/anamnese/salvar">

<input type="hidden" name="paciente_id" value="<?= $paciente['id'] ?>">


<div class="row g-3">

<!-- SAÚDE GERAL -->

<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">

<h6>🧬 Saúde Geral</h6>

<label>Diabetes</label>
<select name="diabetes" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Hipertensão</label>
<select name="hipertensao" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Problema cardíaco</label>
<select name="problema_cardiaco" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<hr>

<label>Gravidez</label>
<select name="gravidez" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Quantas semanas</label>
<textarea name="quantas_semanas" class="form-control mb-2"></textarea>

<label>Outras informações</label>
<textarea name="outras_informacoes" class="form-control"></textarea>

</div>
</div>
</div>


<!-- MEDICAMENTOS -->

<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">

<h6>💊 Medicamentos e Alergias</h6>

<label>Uso de medicamentos contínuos?</label>
<select name="uso_medicamentos" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Quais medicamentos</label>
<textarea name="quais_medicamentos" class="form-control mb-2"></textarea>

<label>Possui alergias?</label>
<select name="alergias" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Quais alergias</label>
<textarea name="quais_alergias" class="form-control mb-2"></textarea>

<label>Já fez alguma cirurgia?</label>
<select name="cirurgias" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Qual(ais)</label>
<textarea name="quais_cirurgias" class="form-control"></textarea>

</div>
</div>
</div>


<!-- HIGIENE BUCAL -->

<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">

<h6>🪥 Higiene Bucal</h6>

<label>Escova os dentes quantas vezes ao dia?</label>
<select name="escovacao_dia" class="form-control mb-2">
<option value="1">1 vez</option>
<option value="2">2 vezes</option>
<option value="3">3 vezes</option>
<option value="4">Mais de 3</option>
</select>

<label>Usa fio dental?</label>
<select name="uso_fio_dental" class="form-control mb-2">
<option value="sim">Sim</option>
<option value="nao">Não</option>
<option value="as_vezes">Às vezes</option>
</select>

<label>Usa enxaguante bucal?</label>
<select name="uso_enxaguante" class="form-control">
<option value="sim">Sim</option>
<option value="nao">Não</option>
</select>

</div>
</div>
</div>


<!-- SINTOMAS -->

<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">

<h6>🦷 Sintomas Odontológicos</h6>

<label>Sente dor em algum dente?</label>
<select name="dor_dente" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Sente dor ao mastigar?</label>
<select name="dor_mastigar" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Sensibilidade ao frio ou quente?</label>
<select name="sensibilidade" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Sangramento gengival?</label>
<select name="sangramento_gengiva" class="form-control">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

</div>
</div>
</div>


<!-- ATM -->

<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">

<h6>🦴 ATM / Função Mandibular</h6>

<label>Dor ao abrir a boca?</label>
<select name="dor_abrir_boca" class="form-control mb-2">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

<label>Estalos na mandíbula?</label>
<select name="estalo_mandibula" class="form-control">
<option value="nao">Não</option>
<option value="sim">Sim</option>
</select>

</div>
</div>
</div>


<!-- OBSERVAÇÕES -->

<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">

<h6>📝 Observações Clínicas</h6>

<textarea name="observacoes" class="form-control" rows="4"></textarea>

</div>
</div>
</div>

</div>


<hr>

<h5>✍ Assinatura do Paciente</h5>

<canvas id="assinatura" width="400" height="150"
style="border:1px solid #ccc;border-radius:6px;"></canvas>

<br><br>

<button type="button" class="btn btn-secondary"
onclick="limparAssinatura()">

Limpar assinatura

</button>

<input type="hidden" name="assinatura" id="assinatura_input">


<br><br>

<button class="btn btn-success">
Salvar Anamnese
</button>

<a href="<?= BASE_URL ?>/anamnese/pdf/<?= $paciente['id'] ?>"
class="btn btn-primary">
📄 Gerar PDF da Anamnese
</a>

<a href="<?= BASE_URL ?>/prontuarios/index/<?= $paciente['id'] ?>"
class="btn btn-secondary">
Voltar ao Prontuário
</a>

<br><br><br>

</form>


<script>

let canvas = document.getElementById("assinatura");
let ctx = canvas.getContext("2d");

let desenhando = false;

canvas.addEventListener("mousedown",function(e){
desenhando=true;
ctx.moveTo(e.offsetX,e.offsetY);
});

canvas.addEventListener("mousemove",function(e){

if(!desenhando) return;

ctx.lineTo(e.offsetX,e.offsetY);
ctx.stroke();

});

canvas.addEventListener("mouseup",function(){
desenhando=false;

document.getElementById("assinatura_input").value =
canvas.toDataURL();

});

function limparAssinatura(){

ctx.clearRect(0,0,canvas.width,canvas.height);

}

</script>