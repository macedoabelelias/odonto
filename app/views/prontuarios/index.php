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

<div class="col-lg-9">

<div class="card mb-4">

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

<div id="tooltipDente"></div>

</div>

</div>

</div>



<!-- LATERAL -->

<div class="col-lg-3">

<div class="card mb-3 shadow-sm">

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


<div class="card shadow-sm">

<div class="card-body">

<h6>📸 Radiografias</h6>

<input type="file" class="form-control mb-3">

<div style="height:90px;background:#eef2f7;border-radius:8px"></div>

</div>

</div>

</div>

</div>



<!-- ================= SCRIPT ODONTOGRAMA ================= -->

<script>

let denteSelecionado = null;


/* ================= MAPA PERMANENTE ================= */

const mapaPermanente = {

18:{x:40,y:80},
17:{x:92,y:80},
16:{x:145,y:80},
15:{x:195,y:80},
14:{x:245,y:80},
13:{x:295,y:80},
12:{x:340,y:80},
11:{x:390,y:80},

21:{x:440,y:80},
22:{x:485,y:80},
23:{x:535,y:80},
24:{x:585,y:80},
25:{x:635,y:80},
26:{x:690,y:80},
27:{x:742,y:80},
28:{x:792,y:80},

48:{x:40,y:205},
47:{x:92,y:205},
46:{x:145,y:205},
45:{x:195,y:205},
44:{x:245,y:205},
43:{x:295,y:205},
42:{x:340,y:205},
41:{x:390,y:205},

31:{x:440,y:205},
32:{x:485,y:205},
33:{x:535,y:205},
34:{x:585,y:205},
35:{x:635,y:205},
36:{x:690,y:205},
37:{x:742,y:205},
38:{x:792,y:205}

};



/* ================= MAPA DECIDUO ================= */

const mapaDeciduo = {

55:{x:160,y:90},
54:{x:230,y:90},
53:{x:290,y:90},
52:{x:340,y:90},
51:{x:395,y:90},

61:{x:445,y:90},
62:{x:495,y:90},
63:{x:550,y:90},
64:{x:610,y:90},
65:{x:670,y:90},

85:{x:160,y:190},
84:{x:230,y:190},
83:{x:290,y:190},
82:{x:340,y:190},
81:{x:395,y:190},

71:{x:445,y:190},
72:{x:495,y:190},
73:{x:550,y:190},
74:{x:610,y:190},
75:{x:670,y:190}

};



/* ================= GERAR ODONTOGRAMA ================= */

function gerarOdontograma(mapa){

const container = document.getElementById("odontograma");

document.querySelectorAll(".tooth").forEach(el=>el.remove());

Object.keys(mapa).forEach(function(dente){

const pos = mapa[dente];

const tooth = document.createElement("div");

tooth.className = "tooth";
tooth.dataset.dente = dente;

tooth.style.left = pos.x + "px";
tooth.style.top = pos.y + "px";

tooth.innerHTML = `<div class="proc-layer"></div>`;

tooth.addEventListener("click",function(){

denteSelecionado = this.dataset.dente;

console.log("Dente selecionado:", denteSelecionado);

});

container.appendChild(tooth);

});

}



/* ================= TROCAR DENTIÇÃO ================= */

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


/* ================= INICIAR ================= */

document.addEventListener("DOMContentLoaded",function(){

gerarOdontograma(mapaPermanente);

});

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
<div class="card shadow-sm card-compacto">

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

<div class="row mt-3">

<div class="col-md-6">

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



<div class="col-md-6">

<div class="card shadow-sm">

<div class="card-body">

<h6>🦷 Plano de Tratamento</h6>

<textarea id="planoTratamento"
class="form-control mb-3"
rows="4"
placeholder="Descrever plano de tratamento..."></textarea>

<button class="btn btn-success w-100">
Salvar Plano
</button>

</div>

</div>

</div>



