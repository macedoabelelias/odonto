<h4 class="mb-4">🦷 Prontuário do Paciente</h4>

<input type="hidden" id="paciente_id" value="<?= $paciente['id'] ?>">

<div class="row">

<!-- ODONTOGRAMA -->
<div class="col-lg-8" style="margin-top: 80px;">

<div class="card mb-3">
<div class="card-body" >

<label><strong>Tipo de Dentição</strong></label>

<select id="tipoDenticao" class="form-select mb-3" style="max-width:250px;">
<option value="permanente">Permanente</option>
<option value="deciduo">Decíduo</option>
</select>

<div id="odontograma" class="odontograma text-center">

<img id="imgOdontograma"
class="odontograma-img permanente"
src="<?= BASE_URL ?>/assets/img/dentesperm.png">

</div>

</div>
</div>

</div>



<!-- LATERAL -->
<div class="col-lg-4">


<!-- DENTE SELECIONADO -->
<div class="card mb-3 shadow-sm card-compact">
<div class="card-body">

<h5>🦷 Dente Selecionado</h5>

<p id="infoDente" class="text-muted">
Nenhum selecionado
</p>

<label>Procedimento</label>

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

<select id="statusProcedimento" class="form-control mb-2">

<option value="planejado">A realizar</option>
<option value="realizado">Realizado</option>

</select>

<label>Observações</label>

<label class="mt-2"><strong>Histórico do dente</strong></label>

<div id="historicoDente" 
style="max-height:120px; overflow-y:auto; font-size:13px; background:#f8fafc; padding:8px; border-radius:6px;">
Nenhum registro
</div>

<textarea id="observacoes" class="form-control mb-2" rows="2"></textarea>
<button id="salvarRegistro" class="btn btn-success w-100">
Salvar
</button>

<button id="removerRegistro" class="btn btn-danger w-100 mt-2">
Remover Procedimento
</button>

</div>
</div>



<!-- RADIOGRAFIAS -->
<div class="card mb-3 shadow-sm card-compact">
<div class="card-body">

<h5>📸 Radiografias</h5>

<input type="file" class="form-control mb-3">

<div style="height:90px;background:#f1f5f9;border-radius:8px;"></div>

</div>
</div>
</div>

<div class="row mb-3">

<!-- LEGENDA -->
<div class="col-md-6">

<div class="card shadow-sm">
<div class="card-body">

<h6 class="mb-3">🦷 Legenda do Odontograma</h6>

<div class="odontograma-legenda">

<div class="legenda-item"><span class="legenda-cor carie"></span>Cárie</div>
<div class="legenda-item"><span class="legenda-cor restauracao"></span>Restauração</div>
<div class="legenda-item"><span class="legenda-cor canal"></span>Canal</div>
<div class="legenda-item"><span class="legenda-cor coroa"></span>Coroa</div>
<div class="legenda-item"><span class="legenda-cor implante"></span>Implante</div>
<div class="legenda-item"><span class="legenda-cor selante"></span>Selante</div>
<div class="legenda-item"><span class="legenda-cor profilaxia"></span>Profilaxia</div>
<div class="legenda-item"><span class="legenda-cor raspagem"></span>Raspagem</div>
<div class="legenda-item"><span class="legenda-cor cirurgia"></span>Cirurgia</div>

<div class="legenda-item"><span class="legenda-x vermelho"></span>Extração indicada</div>
<div class="legenda-item"><span class="legenda-x preto"></span>Extração realizada</div>

</div>

</div>
</div>

</div>



<!-- RECOMENDAÇÕES -->
<div class="col-md-6">

<div class="card shadow-sm">
<div class="card-body">

<h6 class="mb-3">💡 Recomendações</h6>

<div class="mb-2">
<strong>✨ Clareamento Dental</strong>
<p style="font-size:13px">
Recupere o brilho do seu sorriso com clareamento profissional.
</p>
</div>

<!-- <div class="mb-2">
<strong>🦷 Implantes Dentários</strong>
<p style="font-size:13px">
Substitua dentes perdidos com segurança e estética.
</p>
</div> -->

<div>
<strong>📅 Lembrete</strong>
<p style="font-size:13px">
Profilaxia recomendada a cada 6 meses.
</p>

<button class="btn btn-outline-primary btn-sm w-100">
Agendar Retorno
</button>

</div>

</div>
</div>

</div>

</div>




<hr class="my-4">

<div class="row">

<!-- EVOLUÇÃO -->
<div class="col-md-6">

<div class="card shadow-sm">
<div class="card-body">

<h5>📋 Evolução Clínica</h5>

<textarea class="form-control mb-3" rows="4"
placeholder="Registrar evolução clínica..."></textarea>

<button class="btn btn-primary w-100">
Salvar Evolução
</button>

</div>
</div>

</div>



<!-- PLANO -->
<div class="col-md-6">

<div class="card shadow-sm">
<div class="card-body">

<h5>🦷 Plano de Tratamento</h5>

<textarea id="planoTratamento" class="form-control mb-3" rows="4"
placeholder="Descrever plano de tratamento..."></textarea>

<button class="btn btn-success w-100">
Salvar Plano
</button>

</div>
</div>

</div>

</div>


<script>

/* ================= VARIÁVEIS ================= */

let denteSelecionado = null


/* ================= GERAR ODONTOGRAMA ================= */

function gerarOdontograma(mapa){

const container = document.getElementById("odontograma")

document.querySelectorAll(".tooth").forEach(el=>el.remove())

Object.keys(mapa).forEach(function(dente){

const pos = mapa[dente]

const tooth = document.createElement("div")

tooth.className = "tooth"
tooth.dataset.dente = dente

tooth.style.left = pos.x + "px"
tooth.style.top = pos.y + "px"

tooth.innerHTML = `
<div class="proc-layer"></div>
`

container.appendChild(tooth)

})

ativarCliques()

carregarOdontograma()

}


/* ================= CLIQUE NO DENTE ================= */

function ativarCliques(){

document.querySelectorAll(".tooth").forEach(function(tooth){

tooth.addEventListener("click",function(){

document.querySelectorAll(".tooth").forEach(t=>t.classList.remove("tooth-ativo"))

this.classList.add("tooth-ativo")

denteSelecionado = this.dataset.dente

document.getElementById("infoDente").innerText =
"Dente selecionado: " + denteSelecionado

carregarHistoricoDente(denteSelecionado)

})

})

}


/* ================= MAPA PERMANENTE ================= */

const mapaPermanente = {

18:{x:14,y:78},
17:{x:70,y:76},
16:{x:128,y:76},
15:{x:178,y:76},
14:{x:226,y:76},
13:{x:274,y:76},
12:{x:309,y:76},
11:{x:364,y:76},

21:{x:432,y:76},
22:{x:479,y:76},
23:{x:528,y:76},
24:{x:576,y:76},
25:{x:612,y:76},
26:{x:668,y:76},
27:{x:725,y:76},
28:{x:780,y:78},

48:{x:22,y:186},
47:{x:82,y:188},
46:{x:148,y:188},
45:{x:198,y:188},
44:{x:246,y:188},
43:{x:290,y:188},
42:{x:328,y:188},
41:{x:368,y:188},

31:{x:420,y:188},
32:{x:458,y:188},
33:{x:498,y:188},
34:{x:542,y:188},
35:{x:592,y:188},
36:{x:648,y:188},
37:{x:714,y:188},
38:{x:768,y:186}

}


/* ================= MAPA DECÍDUO ================= */

const mapaDeciduo = {

55:{x:155,y:52},
54:{x:217,y:52},
53:{x:270,y:52},
52:{x:313,y:52},
51:{x:366,y:52},

61:{x:430,y:52},
62:{x:478,y:52},
63:{x:521,y:52},
64:{x:574,y:52},
65:{x:634,y:52},

85:{x:166,y:170},
84:{x:232,y:170},
83:{x:286,y:170},
82:{x:328,y:170},
81:{x:368,y:170},

71:{x:421,y:170},
72:{x:470,y:170},
73:{x:512,y:170},
74:{x:560,y:170},
75:{x:628,y:170}

}


/* ================= TROCAR DENTIÇÃO ================= */

document.getElementById("tipoDenticao").addEventListener("change",function(){

const tipo = this.value
const img = document.getElementById("imgOdontograma")

if(tipo==="permanente"){

img.src = "<?= BASE_URL ?>/assets/img/dentesperm.png"
img.classList.remove("deciduo")
img.classList.add("permanente")

gerarOdontograma(mapaPermanente)

}else{

img.src = "<?= BASE_URL ?>/assets/img/dentesdec.png"
img.classList.remove("permanente")
img.classList.add("deciduo")

gerarOdontograma(mapaDeciduo)

}

})


/* ================= SALVAR PROCEDIMENTO ================= */

document.getElementById("salvarRegistro").addEventListener("click",function(){

if(!denteSelecionado){

alert("Selecione um dente primeiro")
return

}

const procedimento = document.getElementById("procedimento").value
const status = document.getElementById("statusProcedimento").value
const obs = document.getElementById("observacoes").value

fetch("<?= BASE_URL ?>/prontuarios/salvarRegistro",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:new URLSearchParams({

paciente_id:document.getElementById("paciente_id").value,
dente:denteSelecionado,
procedimento:procedimento,
status:status,
observacoes:obs

})

})
.then(res=>res.json())
.then(ret=>{

if(ret.status==="ok"){

/* atualiza odontograma */

aplicarProcedimento(denteSelecionado,procedimento,status)

/* atualiza histórico */

carregarHistoricoDente(denteSelecionado)

/* atualiza plano de tratamento */

gerarPlanoTratamento()

/* limpa campos */

document.getElementById("procedimento").value=""
document.getElementById("observacoes").value=""

alert("Registro salvo")

}

})

})



/* ================= REMOVER PROCEDIMENTO ================= */

document.getElementById("removerRegistro").addEventListener("click",function(){

if(!denteSelecionado){

alert("Selecione um dente primeiro")
return

}

if(!confirm("Deseja remover os procedimentos deste dente?")){
return
}

fetch("<?= BASE_URL ?>/prontuarios/removerRegistro",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:new URLSearchParams({

paciente_id:document.getElementById("paciente_id").value,
dente:denteSelecionado

})

})
.then(res=>res.json())
.then(ret=>{

if(ret.status==="ok"){

const tooth = document.querySelector(
`.tooth[data-dente="${denteSelecionado}"]`
)

if(!tooth) return

const layer = tooth.querySelector(".proc-layer")

if(layer){
layer.innerHTML=""
}

document.getElementById("historicoDente").innerHTML="Nenhum registro"

alert("Procedimentos removidos")

}

})

})



/* ================= APLICAR PROCEDIMENTO NO DENTE ================= */

function aplicarProcedimento(dente,procedimento,status){

const tooth = document.querySelector(
`.tooth[data-dente="${dente}"]`
)

if(!tooth) return

const layer = tooth.querySelector(".proc-layer")

if(!layer) return


/* EXTRAÇÃO INDICADA */

if(procedimento === "extracao_indicada"){

const x = document.createElement("div")
x.className = "extracao-x"

tooth.appendChild(x)

return

}


/* EXTRAÇÃO REALIZADA */

if(procedimento === "extracao_realizada"){

const x = document.createElement("div")
x.className = "extracao-realizada-x"

tooth.appendChild(x)

tooth.classList.add("tooth-ausente")

return

}


/* OUTROS PROCEDIMENTOS */

const item = document.createElement("div")

item.classList.add("proc-item")

/* posição do procedimento */

if(procedimento === "restauracao" || procedimento === "carie" || procedimento === "profilaxia" || procedimento === "raspagem"){
item.classList.add("proc-centro")
}

if(procedimento === "canal"){
item.classList.add("proc-raiz")
}

if(procedimento === "coroa"){
item.classList.add("proc-topo")
}

if(procedimento === "implante"){
item.classList.add("proc-implante")
}

item.style.backgroundImage =
`url("<?= BASE_URL ?>/assets/odontograma/${procedimento}_${status}.png")`

layer.appendChild(item)

}

/* ================= CARREGAR ODONTOGRAMA ================= */

function carregarOdontograma(){

const paciente_id = document.getElementById("paciente_id").value

fetch("<?= BASE_URL ?>/prontuarios/registros/"+paciente_id)

.then(res=>res.json())

.then(dados=>{

dados.forEach(reg=>{

aplicarProcedimento(reg.dente,reg.procedimento,reg.status)

})

})

}


/* ================= CARREGAR HISTÓRICO DO DENTE ================= */

function carregarHistoricoDente(dente){

const paciente_id = document.getElementById("paciente_id").value

fetch("<?= BASE_URL ?>/prontuarios/historico/"+paciente_id+"/"+dente)

.then(res=>res.json())

.then(dados=>{

const box = document.getElementById("historicoDente")

if(!box) return

if(dados.length===0){

box.innerHTML="Nenhum registro"
return

}

let html=""

dados.forEach(reg=>{

html += `
<div style="border-bottom:1px solid #e5e7eb;padding:4px 0;">
<strong>${reg.procedimento}</strong> (${reg.status})<br>
<span style="color:#64748b;font-size:12px">${reg.data}</span>
</div>
`

})

box.innerHTML=html

})

}

/* ================= GERAR PLANO DE TRATAMENTO ================= */

function gerarPlanoTratamento(){

const paciente_id = document.getElementById("paciente_id").value

fetch("<?= BASE_URL ?>/prontuarios/registros/"+paciente_id)

.then(res=>res.json())

.then(dados=>{

const campo = document.getElementById("planoTratamento")

if(!campo) return

let texto = ""

dados.forEach(reg=>{

if(reg.status === "a_realizar"){

texto += "• " + reg.procedimento + " — dente " + reg.dente + "\n"

}

})

if(texto===""){
texto="Nenhum procedimento pendente"
}

campo.value = texto

})

}

/* ================= INICIAR ODONTOGRAMA ================= */

document.addEventListener("DOMContentLoaded", function(){

gerarOdontograma(mapaPermanente)

gerarPlanoTratamento()

})

</script>