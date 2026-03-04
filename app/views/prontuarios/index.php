<h4 class="mb-4">🦷 Prontuário do Paciente</h4>

<input type="hidden" id="paciente_id" value="<?= $paciente['id'] ?>">

<div class="row">

<!-- ODONTOGRAMA -->
<div class="col-lg-8" style="margin-top: 40px;">

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

<label>Observações</label>

<textarea id="observacoes" class="form-control mb-2" rows="2"></textarea>
<button id="salvarRegistro" class="btn btn-success w-100">
Salvar
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

<div class="mb-2">
<strong>🦷 Implantes Dentários</strong>
<p style="font-size:13px">
Substitua dentes perdidos com segurança e estética.
</p>
</div>

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

<textarea class="form-control mb-3" rows="4"
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
let faceSelecionada = null


/* ================= FUNÇÃO GERAR ODONTOGRAMA ================= */

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
<div class="face vestibular" data-face="V"></div>
<div class="face lingual" data-face="L"></div>
<div class="face mesial" data-face="M"></div>
<div class="face distal" data-face="D"></div>
<div class="face oclusal" data-face="O"></div>
`

container.appendChild(tooth)

})

ativarCliques()

carregarOdontograma()

}



/* ================= ATIVAR CLIQUES ================= */

function ativarCliques(){

document.querySelectorAll(".face").forEach(function(face){

face.addEventListener("click",function(){

document.querySelectorAll(".face").forEach(f=>f.classList.remove("ativo"))

this.classList.add("ativo")

const tooth = this.closest(".tooth")

denteSelecionado = tooth.dataset.dente
faceSelecionada = this.dataset.face

document.getElementById("infoDente").innerText =
"Dente: " + denteSelecionado + " | Face: " + faceSelecionada

})

})

}



/* ================= MAPA PERMANENTE ================= */

const mapaPermanente = {

18:{x:22,y:110},
17:{x:82,y:110},
16:{x:148,y:110},
15:{x:207,y:110},
14:{x:258,y:110},
13:{x:309,y:110},
12:{x:359,y:110},
11:{x:412,y:110},

21:{x:496,y:110},
22:{x:549,y:110},
23:{x:598,y:110},
24:{x:650,y:110},
25:{x:701,y:110},
26:{x:762,y:110},
27:{x:825,y:110},
28:{x:884,y:110},

48:{x:32,y:205},
47:{x:98,y:205},
46:{x:170,y:205},
45:{x:232,y:205},
44:{x:286,y:205},
43:{x:336,y:205},
42:{x:378,y:205},
41:{x:428,y:205},

31:{x:482,y:205},
32:{x:525,y:205},
33:{x:570,y:205},
34:{x:622,y:205},
35:{x:675,y:205},
36:{x:738,y:205},
37:{x:810,y:205},
38:{x:878,y:205}

}



/* ================= MAPA DECÍDUO ================= */

const mapaDeciduo = {

55:{x:175,y:92},
54:{x:247,y:92},
53:{x:305,y:92},
52:{x:358,y:92},
51:{x:410,y:92},

61:{x:492,y:92},
62:{x:545,y:92},
63:{x:597,y:92},
64:{x:658,y:92},
65:{x:728,y:92},

85:{x:180,y:190},
84:{x:262,y:190},
83:{x:320,y:190},
82:{x:370,y:190},
81:{x:418,y:190},

71:{x:481,y:190},
72:{x:530,y:190},
73:{x:580,y:190},
74:{x:644,y:190},
75:{x:725,y:190}

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


/* ================= SALVAR REGISTRO ================= */

document.getElementById("salvarRegistro").addEventListener("click",function(){

if(!denteSelecionado){

alert("Selecione uma face primeiro")

return

}

const procedimento = document.getElementById("procedimento").value
const obs = document.getElementById("observacoes").value

fetch("<?= BASE_URL ?>/prontuarios/salvarRegistro",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:new URLSearchParams({

paciente_id:document.getElementById("paciente_id").value,
dente:denteSelecionado,
face:faceSelecionada,
procedimento:procedimento,
observacoes:obs

})

})
.then(res=>res.json())
.then(ret=>{

if(ret.status==="ok"){

const face = document.querySelector(
`.tooth[data-dente="${denteSelecionado}"] .face[data-face="${faceSelecionada}"]`
)

if(procedimento){

face.classList.add(procedimento)

}

alert("Registro salvo")

}

})

})



/* ================= CARREGAR REGISTROS ================= */

function carregarOdontograma(){

const paciente_id = document.getElementById("paciente_id").value

fetch("<?= BASE_URL ?>/prontuarios/registros/"+paciente_id)

.then(res=>res.json())

.then(dados=>{

dados.forEach(reg=>{

const face = document.querySelector(
`.tooth[data-dente="${reg.dente}"] .face[data-face="${reg.face}"]`
)

if(face){

face.classList.add(reg.procedimento)

}

})

})

}



/* ================= INICIAR ================= */

gerarOdontograma(mapaPermanente)

</script>