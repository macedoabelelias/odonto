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

<div class="col-lg-9" style="border-radius:14px; ">

<div class="card shadow-sm mb-4" style="margin-top: 98px;">

<div class="card-body text-center" style="box-shadow:0 2px 8px rgba(2,0,0,1.2)">

<label><strong>Tipo de Dentição</strong></label>

<select id="tipoDenticao" class="form-select mb-3" style="max-width:250px;margin:auto">

<option value="permanente">Permanente</option>
<option value="deciduo">Decíduo</option>

</select>


<div id="odontograma" class="odontograma">

<img id="imgOdontograma"
class="odontograma-img permanente"
src="<?= BASE_URL ?>/assets/img/dentesperm.png">

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
<option value="extracao_indicada">Extração indicada</option>
<option value="extracao_realizada">Extração realizada</option>

</select>

<input type="hidden" id="denteSelecionado">

<label>Dente selecionado</label>

<input type="text" id="denteVisual" class="form-control mb-2" readonly>

<label>Status</label>

<select id="statusProcedimento" class="form-control mb-2">

<option value="planejado">A realizar</option>
<option value="realizado">Realizado</option>

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

<script>

let denteSelecionado = null;


/* MAPA PERMANENTE */

const mapaPermanente = {

18:{x:138,y:210},
17:{x:184,y:210},
16:{x:232,y:210},
15:{x:278,y:210},
14:{x:314,y:210},
13:{x:355,y:210},
12:{x:390,y:210},
11:{x:432,y:210},

21:{x:490,y:210},
22:{x:532,y:210},
23:{x:570,y:210},
24:{x:608,y:210},
25:{x:646,y:210},
26:{x:692,y:210},
27:{x:740,y:210},
28:{x:782,y:210},

48:{x:146,y:260},
47:{x:194,y:260},
46:{x:248,y:260},
45:{x:294,y:260},
44:{x:334,y:260},
43:{x:374,y:260},
42:{x:408,y:260},
41:{x:438,y:260},

31:{x:486,y:260},
32:{x:516,y:260},
33:{x:550,y:260},
34:{x:588,y:260},
35:{x:628,y:260},
36:{x:672,y:260},
37:{x:726,y:260},
38:{x:774,y:260}

};


/* MAPA DECIDUO */

const mapaDeciduo = {

55:{x:308,y:166},
54:{x:348,y:166},
53:{x:380,y:166},
52:{x:408,y:166},
51:{x:438,y:166},

61:{x:480,y:166},
62:{x:511,y:166},
63:{x:538,y:166},
64:{x:572,y:166},
65:{x:612,y:166},

85:{x:312,y:206},
84:{x:356,y:206},
83:{x:390,y:202},
82:{x:416,y:206},
81:{x:438,y:206},

71:{x:476,y:206},
72:{x:504,y:206},
73:{x:530,y:202},
74:{x:562,y:206},
75:{x:608,y:206}

};


/* GERAR ODONTOGRAMA */

function gerarOdontograma(mapa){

const container = document.getElementById("odontograma");

// remove dentes antigos
document.querySelectorAll(".tooth").forEach(el => el.remove());

Object.keys(mapa).forEach(function(dente){

const pos = mapa[dente];

// cria o dente
const tooth = document.createElement("div");

tooth.className = "tooth";
tooth.dataset.dente = dente;

// posição
tooth.style.position = "absolute";
tooth.style.left = pos.x + "px";
tooth.style.top = pos.y + "px";

// tamanho clicável
tooth.style.width = "28px";
tooth.style.height = "28px";
tooth.style.cursor = "pointer";

// camada de procedimento
const camada = document.createElement("div");
camada.className = "proc-layer";
tooth.appendChild(camada);

// evento clique
tooth.onclick = function(){

denteSelecionado = this.dataset.dente;

// preencher campos
document.getElementById("denteSelecionado").value = denteSelecionado;
document.getElementById("denteVisual").value = denteSelecionado;

carregarHistorico(denteSelecionado);

// remover seleção anterior
document.querySelectorAll(".tooth").forEach(function(t){
t.classList.remove("tooth-ativo");
});

// marcar atual
this.classList.add("tooth-ativo");

};

container.appendChild(tooth);

});

}

/* TROCAR DENTIÇÃO */

document.getElementById("tipoDenticao").addEventListener("change",function(){

const tipo = this.value;

const img = document.getElementById("imgOdontograma");

if(tipo==="permanente"){

img.src = "<?= BASE_URL ?>/assets/img/dentesperm.png";

gerarOdontograma(mapaPermanente);

}else{

img.src = "<?= BASE_URL ?>/assets/img/dentesdec.png";

gerarOdontograma(mapaDeciduo);

}

});


/* INICIAR */

document.addEventListener("DOMContentLoaded",function(){

gerarOdontograma(mapaPermanente);

setTimeout(function(){

carregarProcedimentos();
carregarHistoricoPaciente();

},300);

});

/* SALVAR REGISTRO */

// const btnSalvar = document.getElementById("salvarRegistro");

if(btnSalvar){

btnSalvar.addEventListener("click",function(){

let paciente = document.getElementById("paciente_id").value;
let dente = document.getElementById("denteSelecionado").value;
let procedimento = document.getElementById("procedimento").value;
let status = document.getElementById("statusProcedimento").value;
let observacoes = document.getElementById("observacoes").value;

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
`paciente_id=${paciente}&dente=${dente}&procedimento=${procedimento}&status=${status}&observacoes=${observacoes}`

})
.then(res=>res.json())
.then(data=>{

if(data.status==="ok"){

pintarDente(dente,procedimento,status);
carregarHistorico(dente);
carregarHistoricoPaciente();

}

})
.catch(error=>{
console.log("Erro:",error);
});

});

}




/* PINTAR DENTE */

function pintarDente(dente,procedimento,status){

let tooth = document.querySelector(`.tooth[data-dente='${dente}']`);

if(!tooth) return;

let camada = tooth.querySelector(".proc-layer");

if(!camada){

camada = document.createElement("div");
camada.className = "proc-layer";
tooth.appendChild(camada);

}

/* caminho correto */

let base = "<?= BASE_URL ?>/assets/img/odontograma/";

/* escolher imagem */

let icone = "";

if(status==="planejado"){
icone = base + procedimento + "_a_realizar.png";
}

if(status==="realizado"){
icone = base + procedimento + "_realizado.png";
}

camada.innerHTML = `<img src="${icone}" width="18">`;

}

/* mostrar ícone */

camada.innerHTML = `
<div style="
display:flex;
align-items:center;
justify-content:center;
width:100%;
height:100%;
">
<img src="${icone}" width="18">
</div>
`;



/* HISTÓRICO */

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

}else{

data.forEach(r=>{

html+=`

<div style="font-size:13px;margin-bottom:6px">

<strong>${new Date(r.data).toLocaleDateString()}</strong><br>

${r.procedimento}

</div>

`;

});

}

/* inserir no card */

document.getElementById("historico_dente").innerHTML = html;

})

.catch(error => {

console.log("Erro ao carregar histórico:", error);

});

}

  document.querySelectorAll(".proc-geral").forEach(function(item){

        item.addEventListener("click",function(){

        let procedimento = this.dataset.proc;

        document.getElementById("procedimento").value = procedimento;

        });

    });

    

</script>


<!-- ================= LEGENDA + RECOMENDAÇÕES ================= -->

<div class="row mt-3">

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
<img src="/odonto/public/assets/img/procedimentos/profilaxia.png" width="28">
<span>Profilaxia</span>
</div>

<div class="proc-geral" data-proc="fluor">
<img src="/odonto/public/assets/img/procedimentos/fluor.png" width="28">
<span>Flúor</span>
</div>

<div class="proc-geral" data-proc="protese_total">
<img src="/odonto/public/assets/img/procedimentos/protese_total.png" width="28">
<span>Prótese Total</span>
</div>

<div class="proc-geral" data-proc="protese_parcial">
<img src="/odonto/public/assets/img/procedimentos/protese_parcial.png" width="28">
<span>Prótese Parcial</span>
</div>

<div class="proc-geral" data-proc="protocolo_implante">
<img src="/odonto/public/assets/img/procedimentos/protocolo_implante.png" width="28">
<span>Protocolo</span>
</div>

<div class="proc-geral" data-proc="placa_bruxismo">
<img src="/odonto/public/assets/img/procedimentos/placa_bruxismo.png" width="28">
<span>Placa Bruxismo</span>
</div>

<div class="proc-geral" data-proc="manutencao_periodontal">
<img src="/odonto/public/assets/img/procedimentos/manutencao_periodontal.png" width="28">
<span>Manutenção</span>
</div>

<div class="proc-geral" data-proc="urgencia">
<img src="/odonto/public/assets/img/procedimentos/urgencia.png" width="28">
<span>Urgência</span>
</div>

<div class="proc-geral" data-proc="raspagem">
<img src="/odonto/public/assets/img/procedimentos/raspagem.png" width="28">
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

</script>

