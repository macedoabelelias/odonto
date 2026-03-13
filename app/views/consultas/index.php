<h4 class="mb-4">Agenda</h4>

<div class="d-flex justify-content-between align-items-center mb-3">

<form method="GET" class="d-flex gap-2">

<select name="dentista" class="form-select" style="width:250px">

<option value="">Todos os dentistas</option>

<?php foreach($dentistas ?? [] as $d): ?>

<option value="<?= $d['id'] ?>"
<?= ($dentistaSelecionado ?? '') == $d['id'] ? 'selected' : '' ?>>

<?= htmlspecialchars($d['nome']) ?>

</option>

<?php endforeach; ?>

</select>

<button class="btn btn-primary">
Filtrar
</button>

</form>

<a href="<?= BASE_URL ?>/consultas/criar" class="btn btn-success">
+ Nova Consulta
</a>

</div>


<!-- ===============================
ESTATÍSTICAS DA AGENDA
================================ -->

<div class="row mb-3">

<div class="col-md-3">
<div class="card border-primary shadow-sm">
<div class="card-body text-center">
<h6 class="text-muted">Consultas Hoje</h6>
<h3><?= $estatisticas['total'] ?? 0 ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card border-warning shadow-sm">
<div class="card-body text-center">
<h6 class="text-muted">Em Atendimento</h6>
<h3><?= $estatisticas['atendimento'] ?? 0 ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card border-success shadow-sm">
<div class="card-body text-center">
<h6 class="text-muted">Finalizadas</h6>
<h3><?= $estatisticas['finalizado'] ?? 0 ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card border-danger shadow-sm">
<div class="card-body text-center">
<h6 class="text-muted">Faltaram</h6>
<h3><?= $estatisticas['faltou'] ?? 0 ?></h3>
</div>
</div>
</div>

</div>


<!-- ===============================
CALENDÁRIO
================================ -->

<div class="card shadow-sm">
<div class="card-body">
<div id="calendar"></div>
</div>
</div>


<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

document.addEventListener('DOMContentLoaded', function() {

var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {

initialView: 'timeGridWeek',

locale: 'pt-br',

height: "auto",

headerToolbar: {
left: 'prev,next today',
center: 'title',
right: 'dayGridMonth,timeGridWeek,timeGridDay'
},

buttonText:{
today:'Hoje',
month:'Mês',
week:'Semana',
day:'Dia'
},

slotMinTime:"08:00:00",
slotMaxTime:"19:00:00",

editable:true,


/* ===============================
CRIAR CONSULTA
================================ */

dateClick:function(info){

let data = info.dateStr.substring(0,10);
let hora = info.dateStr.substring(11,16);

window.location =
"<?= BASE_URL ?>/consultas/criar?data="+data+"&hora="+hora;

},


/* ===============================
CLICAR NA CONSULTA
================================ */

eventClick:function(info){

let id = info.event.id;

let paciente = info.event.title;
let procedimento = info.event.extendedProps.procedimento || '';
let dentista = info.event.extendedProps.dentista || '';

Swal.fire({

title: paciente,

html: `
<b>Procedimento:</b> ${procedimento}<br>
<b>Dentista:</b> ${dentista}
`,

showCancelButton:true,
showDenyButton:true,

<?php if($_SESSION['usuario_nivel']=='recepcionista'){ ?>

confirmButtonText:'Editar Consulta',
denyButtonText:'Paciente Chegou',
cancelButtonText:'Faltou'

<?php } else { ?>

confirmButtonText:'Iniciar Atendimento',
denyButtonText:'Finalizar',
cancelButtonText:'Faltou'

<?php } ?>

}).then((result)=>{

if(result.isConfirmed){

<?php if($_SESSION['usuario_nivel']=='recepcionista'){ ?>

window.location =
"<?= BASE_URL ?>/consultas/editar/"+id;

<?php } else { ?>

window.location =
"<?= BASE_URL ?>/consultas/iniciar/"+id;

<?php } ?>

}

else if(result.isDenied){

alterarStatus(id,'finalizado');

}

else if(result.dismiss === Swal.DismissReason.cancel){

alterarStatus(id,'faltou');

}

});

},


/* ===============================
MOVER CONSULTA
================================ */

eventDrop:function(info){

let id = info.event.id;

let dataHora = info.event.start;

let data = dataHora.toISOString().substring(0,10);
let hora = dataHora.toTimeString().substring(0,5);

fetch("<?= BASE_URL ?>/consultas/mover",{

method:"POST",

headers:{
"Content-Type":"application/json"
},

body: JSON.stringify({
id:id,
data:data,
hora:hora
})

})

.then(res=>res.json())
.then(data=>{

if(!data.success){

alert("Erro ao mover consulta");

info.revert();

}

});

},


/* ===============================
EVENTOS DO BANCO
================================ */

events:[

<?php if(!empty($consultas)): ?>

<?php foreach($consultas as $c):

$cor = "#6ea8fe";

if(isset($c['status'])){

if($c['status']=='atendimento'){
$cor="#f9c74f";
}

elseif($c['status']=='finalizado'){
$cor="#90db9a";
}

elseif($c['status']=='faltou'){
$cor="#f28482";
}

}
?>

{

id:"<?= $c['id'] ?>",

title:"<?= addslashes($c['paciente']) ?>",

start:"<?= $c['data'] ?>T<?= $c['hora'] ?>",

end:"<?= date('Y-m-d\TH:i', strtotime($c['data'].' '.$c['hora'].' +'.($c['duracao'] ?? 30).' minutes')) ?>",

color:"<?= $cor ?>",

extendedProps:{
procedimento:"<?= addslashes($c['procedimento'] ?? '') ?>",
dentista:"<?= addslashes($c['dentista'] ?? '') ?>"
}

},

<?php endforeach; ?>

<?php endif; ?>

],


/* ===============================
VISUAL DO EVENTO
================================ */

eventContent:function(arg){

let procedimento = arg.event.extendedProps.procedimento || '';
let dentista = arg.event.extendedProps.dentista || '';

let html = `
<div style="font-size:12px">

<strong>${arg.event.title}</strong><br>

<span style="opacity:0.9">${procedimento}</span><br>

<span style="opacity:0.6;font-size:11px">${dentista}</span>

</div>
`;

return {html:html};

}

});

calendar.render();

});


/* ===============================
ALTERAR STATUS
================================ */

function alterarStatus(id,status){

fetch("<?= BASE_URL ?>/consultas/status",{

method:"POST",

headers:{
"Content-Type":"application/json"
},

body: JSON.stringify({
id:id,
status:status
})

})

.then(res=>res.json())
.then(data=>{

if(data.success){

location.reload();

}else{

alert("Erro ao atualizar status");

}

});

}

</script>