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

<input type="hidden" id="paciente_id" value="<?= $paciente['id'] ?>">

<div class="mb-3">

<a href="<?= BASE_URL ?>/anamnese/index/<?= $paciente['id'] ?>" class="btn btn-primary">
🩺 Anamnese do Paciente
</a>

<a href="<?= BASE_URL ?>/pacientes" class="btn btn-secondary">
← Voltar
</a>

</div>

<hr>

<div class="row">

<!-- ODONTOGRAMA -->

<div class="col-lg-9" style="border-radius:14px; border-shadow:0 2px 8px rgba(2,0,0,0.1)">

<div class="card mb-4" style="margin-top: 98px;">

<div class="card-body text-center">

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
<option value="profilaxia">Profilaxia</option>
<option value="raspagem">Raspagem</option>
<option value="cirurgia">Cirurgia</option>
<option value="extracao_indicada">Extração indicada</option>
<option value="extracao_realizada">Extração realizada</option>

</select>

<label>Status</label>


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

<input type="file" class="form-control mb-3">

<div style="height:90px;background:#eef2f7;border-radius:8px"></div>

</div>

</div>

</div>


<script>

let denteSelecionado = null;


/* MAPA PERMANENTE */

const mapaPermanente = {

18:{x:160,y:226},
17:{x:206,y:228},
16:{x:253,y:228},
15:{x:300,y:224},
14:{x:337,y:224},
13:{x:375,y:222},
12:{x:414,y:226},
11:{x:454,y:224},

21:{x:515,y:224},
22:{x:556,y:226},
23:{x:592,y:222},
24:{x:632,y:224},
25:{x:668,y:226},
26:{x:715,y:228},
27:{x:762,y:228},
28:{x:792,y:212},

48:{x:168,y:274},
47:{x:218,y:276},
46:{x:272,y:274},
45:{x:318,y:274},
44:{x:358,y:274},
43:{x:395,y:276},
42:{x:428,y:274},
41:{x:461,y:274},

31:{x:508,y:274},
32:{x:538,y:274},
33:{x:572,y:278},
34:{x:612,y:276},
35:{x:650,y:274},
36:{x:695,y:274},
37:{x:750,y:276},
38:{x:798,y:276}

};


/* MAPA DECIDUO */

const mapaDeciduo = {

55:{x:331,y:180},
54:{x:370,y:180},
53:{x:402,y:180},
52:{x:430,y:180},
51:{x:460,y:180},

61:{x:505,y:180},
62:{x:535,y:180},
63:{x:562,y:180},
64:{x:595,y:180},
65:{x:632,y:180},

85:{x:332,y:220},
84:{x:378,y:220},
83:{x:412,y:218},
82:{x:438,y:218},
81:{x:465,y:220},

71:{x:500,y:220},
72:{x:525,y:218},
73:{x:552,y:218},
74:{x:588,y:220},
75:{x:631,y:220}

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

// pequeno delay para garantir que os dentes existam
setTimeout(function(){

carregarProcedimentos();

},300);

});

/* SALVAR REGISTRO */

document.getElementById("salvarRegistro").addEventListener("click",function(){

let paciente = document.getElementById("paciente_id").value;
let dente = document.getElementById("denteSelecionado").value;
let procedimento = document.getElementById("procedimento").value;
let status = document.getElementById("statusProcedimento").value;
let observacoes = document.getElementById("observacoes").value;

if(!dente){
alert("Selecione um dente primeiro");
return;
}

fetch("/odonto/public/prontuarios/salvarRegistro",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:
`paciente_id=${paciente}&dente=${dente}&procedimento=${procedimento}&status=${status}&observacoes=${observacoes}`

})
.then(res=>res.json())
.then(data=>{

if(data.status=="ok"){

pintarDente(dente,procedimento);

}

})
.catch(error=>{
console.log(error);
});

});


/* PINTAR DENTE */

function pintarDente(dente,procedimento){

let tooth = document.querySelector(`.tooth[data-dente='${dente}']`);

if(!tooth) return;

let camada = tooth.querySelector(".proc-layer");

if(!camada){

camada = document.createElement("div");
camada.className="proc-layer";
tooth.appendChild(camada);

}

camada.innerHTML = `<div class="proc-item" 
style="background-image:url('<?= BASE_URL ?>assets/img/procedimentos/${procedimento}.png')"></div>`;

}

function carregarProcedimentos(){

let paciente = document.getElementById("paciente_id").value;

fetch("<?= BASE_URL ?>prontuarios/registros/"+paciente)

.then(response => response.json())

.then(dados => {

dados.forEach(function(item){

pintarDente(item.dente,item.procedimento);

});

});

}

  document.querySelectorAll(".proc-geral").forEach(function(item){

        item.addEventListener("click",function(){

        let procedimento = this.dataset.proc;

        document.getElementById("procedimento").value = procedimento;

        });

    });

    function carregarProcedimentos(){

        let paciente = document.getElementById("paciente_id").value;

        fetch("<?= BASE_URL ?>prontuarios/registros/"+paciente)

        .then(response => response.json())

        .then(dados => {

        dados.forEach(function(item){

        pintarDente(item.dente,item.procedimento);

        });

        });

    }

</script>


<!-- ================= LEGENDA + RECOMENDAÇÕES ================= -->

<div class="row mt-3">

    <div class="col-md-4">

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

    <div class="col-md-4">

    <div class="card shadow-sm card-compacto">

        <div class="card-body">

        <h6>💡 Recomendações</h6>
<!-- 
        <strong>✨ Clareamento Dental</strong>

            <p style="font-size:13px">
            Recupere o brilho do seu sorriso com clareamento profissional.
            </p> -->

        <strong>📅 Lembrete</strong>

            <p style="font-size:13px">
            Profilaxia recomendada a cada 6 meses. Fazer agendamento para limpeza e prevenção.
            </p>

        <button class="btn btn-outline-primary btn-sm w-100">
        Agendar Retorno
        </button>

</div>

</div>

</div>

<!-- HISTÓRICO -->
<div class="col-md-4">
<div class="card shadow-sm card-compacto mt-1">

<div class="card-body">

<h6>Histórico do dente</h6>

<div id="historicoDente"
style="max-height:140px;overflow:auto;background:#f8fafc;padding:8px;border-radius:6px">

Nenhum registro

</div>

</div>

</div>



<!-- </div> -->

</div>

<!-- ================= EVOLUÇÃO + PLANO ================= -->

<div class="row mt-4">

<div class="col-md-4">

<div class="card shadow-sm">

<div class="card-body">

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



<div class="col-md-4">

<div class="card shadow-sm">

<div class="card-body">

<h6>🦷 Plano de Tratamento</h6>

<textarea id="planoTratamento"
class="form-control mb-4"
rows="4"
placeholder="Descrever plano de tratamento..."></textarea>

<button class="btn btn-success w-100">
Salvar Plano
</button>

</div>

</div>

</div>

<div class="col-md-4">
<div class="card shadow-sm mt-1">

<div class="card-body">

<h6>🦷 Procedimentos Gerais</h6>

<div class="procedimentos-gerais">

<div class="proc-geral" data-proc="profilaxia">
<img src="/odonto/public/assets/img/procedimentos/profilaxia.png" width="48">
<span>Profilaxia</span>
</div>

<div class="proc-geral" data-proc="fluor">
<img src="/odonto/public/assets/img/procedimentos/fluor.png" width="48">
<span>Flúor</span>
</div>

<div class="proc-geral" data-proc="protese_total">
<img src="/odonto/public/assets/img/procedimentos/protese_total.png" width="48">
<span>Prótese Total</span>
</div>

<div class="proc-geral" data-proc="protese_parcial">
<img src="/odonto/public/assets/img/procedimentos/protese_parcial.png" width="48">
<span>Prótese Parcial</span>
</div>

<div class="proc-geral" data-proc="protocolo_implante">
<img src="/odonto/public/assets/img/procedimentos/protocolo_implante.png" width="48">
<span>Protocolo</span>
</div>

<div class="proc-geral" data-proc="placa_bruxismo">
<img src="/odonto/public/assets/img/procedimentos/placa_bruxismo.png" width="48">
<span>Placa Bruxismo</span>
</div>

<div class="proc-geral" data-proc="manutencao_periodontal">
<img src="/odonto/public/assets/img/procedimentos/manutencao_periodontal.png" width="48">
<span>Manutenção</span>
</div>

<div class="proc-geral" data-proc="urgencia">
<img src="/odonto/public/assets/img/procedimentos/urgencia.png" width="48">
<span>Urgência</span>
</div>

<div class="proc-geral" data-proc="raspagem">
<img src="/odonto/public/assets/img/procedimentos/raspagem.png" width="48">
<span>Raspagem</span>
</div>

</div>

</div>

</div>

</div>

