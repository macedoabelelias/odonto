<?php if(!empty($anamnese)): ?>

<div class="alert alert-warning">

<strong>⚠ Alertas Clínicos</strong>

<ul class="mb-0">

<?php if($anamnese['diabetes']=="sim"): ?>
<li>Paciente diabético</li>
<?php endif; ?>

<?php if($anamnese['hipertensao']=="sim"): ?>
<li>Paciente hipertenso</li>
<?php endif; ?>

<?php if($anamnese['problema_cardiaco']=="sim"): ?>
<li>Problema cardíaco</li>
<?php endif; ?>

<?php if($anamnese['alergias']=="sim"): ?>
<li>Alergia: <?= htmlspecialchars($anamnese['quais_alergias']) ?></li>
<?php endif; ?>

<?php if($anamnese['uso_medicamentos']=="sim"): ?>
<li>Uso de medicamentos: <?= htmlspecialchars($anamnese['quais_medicamentos']) ?></li>
<?php endif; ?>

</ul>

</div>

<?php endif; ?>


<h4 class="mb-4">🦷 Prontuário do Paciente</h4>


<div class="alert alert-info">

<strong>Paciente:</strong> <?= htmlspecialchars($paciente['nome']) ?> |
<strong>Telefone:</strong> <?= htmlspecialchars($paciente['telefone']) ?> |
<strong>Convênio:</strong> <?= htmlspecialchars($paciente['convenio']) ?>

<input type="hidden" id="paciente_id" value="<?= $paciente['id'] ?>">

<br><br>

<a href="<?= BASE_URL ?>/anamnese/index/<?= $paciente['id'] ?>" class="btn btn-primary">
🩺 Anamnese do Paciente
</a>

<a href="<?= BASE_URL ?>/pacientes" class="btn btn-secondary">
← Voltar
</a>

</div>


<div class="row">

<!-- ODONTOGRAMA -->

<div class="col-lg-9" style="border-radius:14px;">

<div class="card shadow-sm mb-4" style="margin-top:140px;">

<div class="card-body text-center" style="box-shadow:0 2px 8px rgba(2,0,0,1.2)">

<label><strong>Tipo de Dentição</strong></label>

<select id="tipoDenticao" class="form-select mb-3" style="max-width:250px;margin:auto">
<option value="permanente">Permanente</option>
<option value="deciduo">Decíduo</option>
</select>

<div id="odontograma"
style="position:relative;width:680px;height:320px;margin:auto;">

<img id="imgOdontograma"
src="<?= BASE_URL ?>/assets/img/odontograma/dentesperm.png"
style="width:680px;height:auto;display:block;margin:auto;">

</div>


</div>

</div>

</div>


<!-- LATERAL -->

<div class="col-lg-3">

<div class="card shadow-sm">

<div class="card-body">

<h6>🦷 Procedimento</h6>

<select id="procedimento" class="form-control mb-2">

<option value="">Selecione</option>
<option value="carie">Cárie</option>
<option value="restauracao">Restauração</option>
<option value="canal">Canal</option>
<option value="coroa">Coroa</option>
<option value="implante">Implante</option>
<option value="cirurgia">Cirurgia</option>
<option value="extracao">Extração</option>

</select>

<input type="hidden" id="denteSelecionado">

<label>Dente selecionado</label>

<input type="text" id="denteVisual" class="form-control mb-2" readonly>

<label>Status</label>

<select id="statusProcedimento" class="form-control mb-2">

<option value="planejado">A realizar</option>
<option value="realizado">Realizado</option>

</select>

<label>Face do dente</label>

<select id="faceSelecionada" class="form-control mb-2">

<option value="">Dente inteiro</option>
<option value="oclusal">Oclusal</option>
<option value="mesial">Mesial</option>
<option value="distal">Distal</option>
<option value="vestibular">Vestibular</option>
<option value="lingual">Lingual</option>

</select>


<textarea id="observacoes" class="form-control mb-2"
placeholder="Observações"></textarea>


<button id="salvarRegistro" class="btn btn-success w-100 mb-2">
Salvar
</button>

<button id="removerRegistro" class="btn btn-danger w-100">
Remover
</button>

</div>

</div>


<br>


<div class="card shadow-sm">

<div class="card-body">

<h6>📸 Radiografias</h6>

<input type="file" id="arquivoRX" class="form-control mb-2">

<button type="button" id="uploadRX" class="btn btn-primary btn-sm w-100 mb-2">
Enviar Radiografia
</button>

<div id="listaRX"
style="max-height:120px;overflow:auto;background:#eef2f7;border-radius:8px;padding:8px;font-size:13px">

Nenhuma radiografia

</div>

</div>

</div>

</div>

</div>

<style>

.sigla-face{
position:absolute;
bottom:-10px;
left:50%;
transform:translateX(-50%);
font-size:10px;
font-weight:bold;
color:#1e40af;
background:white;
padding:1px 3px;
border-radius:4px;
}

</style>


<script>

let denteSelecionado = null;

/* ================= MAPA PERMANENTE ================= */

const mapaPermanente = {

18:{x:22,y:106},17:{x:62,y:106},16:{x:110,y:106},15:{x:154,y:106},
14:{x:190,y:106},13:{x:226,y:106},12:{x:262,y:106},11:{x:300,y:104},

21:{x:358,y:104},22:{x:396,y:106},23:{x:432,y:106},24:{x:470,y:106},
25:{x:506,y:106},26:{x:548,y:106},27:{x:594,y:106},28:{x:638,y:106},

48:{x:26,y:154},47:{x:74,y:154},46:{x:126,y:154},45:{x:170,y:154},
44:{x:208,y:154},43:{x:246,y:154},42:{x:278,y:154},41:{x:308,y:154},

31:{x:352,y:154},32:{x:382,y:154},33:{x:413,y:154},34:{x:450,y:154},
35:{x:488,y:154},36:{x:532,y:154},37:{x:582,y:154},38:{x:628,y:154}

};

/* ================= MAPA DECÍDUO ================= */

const mapaDeciduo = {

55:{x:104,y:108},54:{x:162,y:108},53:{x:210,y:110},52:{x:250,y:108},51:{x:292,y:108},
61:{x:362,y:108},62:{x:406,y:108},63:{x:446,y:110},64:{x:495,y:108},65:{x:552,y:108},

85:{x:108,y:166},84:{x:172,y:166},83:{x:224,y:162},82:{x:262,y:162},81:{x:300,y:162},
71:{x:354,y:162},72:{x:392,y:162},73:{x:430,y:162},74:{x:482,y:166},75:{x:548,y:162}

};

/* ================= GERAR ODONTOGRAMA ================= */

function gerarOdontograma(mapa){

const container = document.getElementById("odontograma");

document.querySelectorAll(".tooth").forEach(el => el.remove());

Object.keys(mapa).forEach(function(dente){

const pos = mapa[dente];

const tooth = document.createElement("div");

tooth.className = "tooth";
tooth.dataset.dente = dente;

tooth.style.position = "absolute";
tooth.style.left = pos.x + "px";
tooth.style.top = pos.y + "px";
tooth.style.width = "28px";
tooth.style.height = "28px";
tooth.style.cursor = "pointer";
tooth.style.zIndex = "5";

const camada = document.createElement("div");
camada.className = "proc-layer";

const faces = ["O","M","D","V","L"];

faces.forEach(face => {

const faceDiv = document.createElement("div");

faceDiv.className = "face face-"+face;
faceDiv.dataset.face = face;

camada.appendChild(faceDiv);

});



tooth.appendChild(camada);

/* clique */

tooth.onclick = function(){

denteSelecionado = this.dataset.dente;

document.getElementById("denteSelecionado").value = denteSelecionado;
document.getElementById("denteVisual").value = denteSelecionado;

document.querySelectorAll(".tooth").forEach(function(t){
t.classList.remove("tooth-ativo");
});

this.classList.add("tooth-ativo");

};

container.appendChild(tooth);

});

}

/* ================= TROCAR DENTIÇÃO ================= */

document.getElementById("tipoDenticao").addEventListener("change",function(){

const tipo = this.value;
const img = document.getElementById("imgOdontograma");

if(tipo==="permanente"){

img.src = "<?= BASE_URL ?>/assets/img/odontograma/dentesperm.png";
img.style.width = "680px";

gerarOdontograma(mapaPermanente);

}else{

img.src = "<?= BASE_URL ?>/assets/img/odontograma/dentesdec.png";
img.style.width = "520px";

gerarOdontograma(mapaDeciduo);

}

});

/* ================= SALVAR REGISTRO ================= */

const btnSalvar = document.getElementById("salvarRegistro");

if(btnSalvar){

btnSalvar.addEventListener("click",function(){

let paciente = document.getElementById("paciente_id").value;
let dente = document.getElementById("denteSelecionado").value;
let procedimento = document.getElementById("procedimento").value;
let face = document.getElementById("faceSelecionada").value;
let status = document.getElementById("statusProcedimento").value;
let observacoes = document.getElementById("observacoes").value;

if(!procedimento){
alert("Selecione um procedimento");
return;
}

if(!dente){
alert("Selecione um dente primeiro");
return;
}

fetch("<?= BASE_URL ?>/prontuarios/salvarRegistro",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:
`paciente_id=${paciente}&dente=${dente}&face=${face}&procedimento=${procedimento}&status=${status}&observacoes=${observacoes}`

})
.then(res=>res.json())
.then(data=>{

if(data.status==="ok"){

pintarDente(dente,procedimento,status,face);
carregarHistorico(dente);
carregarHistoricoPaciente();

}

})
.catch(error=>{
console.log("Erro:",error);
});

});

}

/* ================= PINTAR DENTE ================= */

function pintarDente(dente,procedimento,status,face){

const tooth = document.querySelector(`.tooth[data-dente='${dente}']`);

if(!tooth) return;

const base = "<?= BASE_URL ?>/assets/img/odontograma/";

let icone="";

if(status==="planejado"){
icone = base + procedimento + "_a_realizar.png";
}

if(status==="realizado"){
icone = base + procedimento + "_realizado.png";
}

const camada = tooth.querySelector(".proc-layer");

/* ícone central */

const novoIcone = document.createElement("img");

novoIcone.src = icone;
novoIcone.className = "icone-procedimento";

camada.appendChild(novoIcone);

/* pintar faces */

if(face){

const letras = face.split("");

letras.forEach(f => {

const faceDiv = tooth.querySelector(".face-"+f);

if(faceDiv){

faceDiv.style.background="#2563eb";

}

});

}

}




/* ================= CARREGAR PROCEDIMENTOS ================= */

function carregarProcedimentos(){

let paciente = document.getElementById("paciente_id").value;

fetch("<?= BASE_URL ?>/prontuarios/registros/"+paciente)

.then(response => response.json())

.then(dados => {

dados.forEach(function(item){

pintarDente(item.dente,item.procedimento,item.status,item.face);

});

});

}

/* ================= INICIAR ================= */

document.addEventListener("DOMContentLoaded",function(){

gerarOdontograma(mapaPermanente);
carregarProcedimentos();

});

</script>



<!-- ================= LEGENDA + RECOMENDAÇÕES ================= -->

<div class="row g-3 mt-3">


    <div class="col-md-3">

        <div class="card shadow-sm card-compacto">

            <div class="card-body">

            <h6>🦷 Legenda do Odontograma</h6>

        <div class="row">

    <div class="col-6">

        <div class="mb-1">🔴 Cárie</div>
        <div class="mb-1">🟣 Canal</div>
        <div class="mb-1">⚫ Implante</div>
        <div class="mb-1">🔵 Restauração</div>

    </div>

    <div class="col-6">

        <div class="mb-1">🟢 Selante</div>
        <div class="mb-1">🟡 Coroa</div>
        <div class="mb-1">🟠 Raspagem</div>
        <div class="mb-1">❌ Extração</div>

    </div>

            </div>

    </div>

    </div>

    </div>

    <div class="col-md-3">

    <div class="card shadow-sm card-compacto">

        <div class="card-body">
            
<h6>💡 Recomendações</h6>

<strong>📅 Lembrete</strong>

<p style="font-size:13px">
Profilaxia recomendada a cada 6 meses. Fazer agendamento para limpeza e prevenção.
</p>

<a href="<?= BASE_URL ?>/consultas/criar?paciente=<?= $paciente['id'] ?>"
class="btn btn-outline-primary btn-sm w-100">

📅 Agendar Retorno

</a>

</div>

</div>

</div>

<!-- HISTÓRICO -->
<div class="col-md-3">
<div class="card shadow-sm  h-100">

<div class="card-body">

<h6>Histórico do dente</h6>

<div id="historico_dente"
style="max-height:140px;overflow:auto;background:#f8fafc;padding:8px;border-radius:6px">

Nenhum registro

</div>

</div>

</div>


</div>

<br>

<div class="col-md-3">

<div class="card shadow-sm h-100">

<div class="card-body">

<h6>📋 Histórico Clínico</h6>

<div id="historicoPaciente"
style="max-height:200px;overflow:auto;background:#f8fafc;padding:10px;border-radius:6px">

Carregando...

</div>

</div>

</div>

</div>

<!-- ================= EVOLUÇÃO + PLANO ================= -->

<!-- EVOLUÇÃO CLÍNICA -->
    <div class="col-md-4">
    <br>
        <div class="card shadow-sm ">

            <div class="card-body p-4">

                <h6>📋 Evolução Clínica</h6>

                <textarea class="form-control mb-3"
                rows="4"
                placeholder="Registrar evolução clínica..."></textarea>

                <button class="btn btn-primary w-100">
                Salvar Evolução
                </button>

            </div>

        </div>

    </div>

 <!-- PLANO DE TRATAMENTO -->
    <div class="col-md-4">
<br>
        <div class="card shadow-sm ">

            <div class="card-body p-4">

                <h6>🦷 Plano de Tratamento</h6>

                <textarea class="form-control mb-3"
                rows="4"
                placeholder="Descrever plano de tratamento..."></textarea>

                <button class="btn btn-success w-100">
                Salvar Plano
                </button>

            </div>

        </div>

    </div>

 <!-- PROCEDIMENTOS GERAIS -->
    <div class="col-md-4">
<br>
        <div class="card shadow-sm">

            <div class="card-body p-0">

                <h6>🦷 Procedimentos Gerais</h6>

                <div class="procedimentos-gerais">

<div class="proc-geral" data-proc="profilaxia">
<img src="/odonto/public/assets/img/odontograma/profilaxia.png" width="28">
<span>Profilaxia</span>
</div>

<div class="proc-geral" data-proc="fluor">
<img src="/odonto/public/assets/img/odontograma/fluor.png" width="28">
<span>Flúor</span>
</div>

<div class="proc-geral" data-proc="protese_total">
<img src="/odonto/public/assets/img/odontograma/protese_total.png" width="28">
<span>Prótese Total</span>
</div>

<div class="proc-geral" data-proc="protese_parcial">
<img src="/odonto/public/assets/img/odontograma/protese_parcial.png" width="28">
<span>Prótese Parcial</span>
</div>

<div class="proc-geral" data-proc="protocolo_implante">
<img src="/odonto/public/assets/img/odontograma/protocolo_implante.png" width="28">
<span>Protocolo</span>
</div>

<div class="proc-geral" data-proc="placa_bruxismo">
<img src="/odonto/public/assets/img/odontograma/placa_bruxismo.png" width="28">
<span>Placa Bruxismo</span>
</div>

<div class="proc-geral" data-proc="manutencao_periodontal">
<img src="/odonto/public/assets/img/odontograma/manutencao_periodontal.png" width="28">
<span>Manutenção</span>
</div>

<div class="proc-geral" data-proc="urgencia">
<img src="/odonto/public/assets/img/odontograma/urgencia.png" width="28">
<span>Urgência</span>
</div>

<div class="proc-geral" data-proc="raspagem">
<img src="/odonto/public/assets/img/odontograma/raspagem.png" width="28">
<span>Raspagem</span>
</div>

</div>

</div>

</div>

</div>
</div>

<script>

function carregarHistorico(dente){

fetch("<?= BASE_URL ?>/prontuarios/historicoDente",{

method:"POST",

headers:{
"Content-Type":"application/json"
},

body: JSON.stringify({

paciente: <?= $paciente['id'] ?>,
dente: dente

})

})

.then(res=>res.json())

.then(data=>{

let html='';

if(data.length==0){

html="Nenhum registro";

}

else{

data.forEach(r=>{

html+=`

<div style="font-size:13px;margin-bottom:6px">

<strong>${new Date(r.data).toLocaleDateString()}</strong><br>

${r.procedimento}

</div>

`;

});

}

document.getElementById("historico_dente").innerHTML=html;

});

}

function carregarHistoricoPaciente(){

let paciente = document.getElementById("paciente_id").value;

fetch("<?= BASE_URL ?>/prontuarios/historicoPaciente/"+paciente)

.then(res=>res.json())

.then(data=>{

let html='';

if(data.length==0){

html="Nenhum registro";

}else{

data.forEach(r=>{

html+=`

<div style="font-size:13px;margin-bottom:8px;border-bottom:1px solid #eee;padding-bottom:6px">

<strong>${new Date(r.data).toLocaleDateString()}</strong><br>

${r.procedimento}

${r.dente ? ' - Dente '+r.dente : ''}

</div>

`;

});

}

document.getElementById("historicoPaciente").innerHTML=html;

});

}

document.getElementById("uploadRX").addEventListener("click",function(){

let paciente = document.getElementById("paciente_id").value;
let dente = document.getElementById("denteSelecionado").value;

let arquivo = document.getElementById("arquivoRX").files[0];

if(!arquivo){
alert("Selecione uma radiografia");
return;
}

let formData = new FormData();

formData.append("arquivo",arquivo);
formData.append("paciente_id",paciente);
formData.append("dente",dente);

fetch("<?= BASE_URL ?>/radiografias/upload",{

method:"POST",
body:formData

})
.then(res=>res.json())
.then(data=>{

if(data.status=="ok"){

alert("Radiografia enviada com sucesso");

}

});

});

function carregarProcedimentos(){

let paciente = document.getElementById("paciente_id").value;

fetch("<?= BASE_URL ?>/prontuarios/registros/"+paciente)

.then(response => response.json())

.then(dados => {

dados.forEach(function(item){

pintarDente(item.dente,item.procedimento,item.status);


});

});

}

/* INICIAR */

document.addEventListener("DOMContentLoaded",function(){

gerarOdontograma(mapaPermanente);

carregarProcedimentos();

});

</script>

