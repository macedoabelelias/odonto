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

<button class="btn btn-primary">Filtrar</button>

</form>

<a href="<?= BASE_URL ?>/consultas/criar" class="btn btn-success">
+ Nova Consulta
</a>

</div>


<!-- ESTATÍSTICAS -->

<div class="row mb-3">

<div class="col-md-3">
<div class="card border-primary shadow-sm text-center">
<h6>Consultas Hoje</h6>
<h3><?= $estatisticas['total'] ?? 0 ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card border-warning shadow-sm text-center">
<h6>Em Atendimento</h6>
<h3><?= $estatisticas['atendimento'] ?? 0 ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card border-success shadow-sm text-center">
<h6>Finalizadas</h6>
<h3><?= $estatisticas['finalizado'] ?? 0 ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card border-danger shadow-sm text-center">
<h6>Faltaram</h6>
<h3><?= $estatisticas['faltou'] ?? 0 ?></h3>
</div>
</div>

</div>


<!-- LEGENDA -->

<div class="mb-3 d-flex gap-2">
<span class="badge" style="background:#6ea8fe">Agendado</span>
<span class="badge" style="background:#f9c74f">Atendimento</span>
<span class="badge" style="background:#90db9a">Finalizado</span>
<span class="badge" style="background:#f28482">Faltou</span>
</div>


<!-- CALENDÁRIO -->

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

    const calendarEl = document.getElementById('calendar');

    if (!calendarEl) {
        console.error("Calendar não encontrado");
        return;
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'timeGridWeek',
        locale: 'pt-br',
        height: "auto",

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        slotMinTime: "08:00:00",
        slotMaxTime: "19:00:00",

        editable: true,

        dateClick: function(info){
            const data = info.dateStr.substring(0,10);
            const hora = info.dateStr.substring(11,16);

            window.location =
            "<?= BASE_URL ?>/consultas/criar?data="+data+"&hora="+hora;
        },

        eventClick: function(info){

            const id = info.event.id;

            Swal.fire({
                title: info.event.title,
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Iniciar',
                denyButtonText: 'Finalizar',
                cancelButtonText: 'Faltou'
            }).then((result)=>{

                if(result.isConfirmed){
                    window.location = "<?= BASE_URL ?>/consultas/iniciar/"+id;
                }
                else if(result.isDenied){
                    alterarStatus(id,'finalizado');
                }
                else{
                    alterarStatus(id,'faltou');
                }

            });

        },

        eventDrop: function(info){

            const id = info.event.id;

            const data = info.event.start.toISOString().substring(0,10);
            const hora = info.event.start.toTimeString().substring(0,5);

            fetch("<?= BASE_URL ?>/consultas/mover",{
                method:"POST",
                headers:{"Content-Type":"application/json"},
                body: JSON.stringify({id,data,hora})
            })
            .then(r=>r.json())
            .then(r=>{
                if(!r.success){
                    alert("Erro ao mover");
                    info.revert();
                }
            });

        },

        events: [

            <?php foreach($consultas as $i => $c): ?>

            {
                id: "<?= $c['id'] ?>",
                title: <?= json_encode($c['paciente']) ?>,
                start: "<?= $c['data'] ?>T<?= $c['hora'] ?>",
                color: "<?= $c['status']=='faltou'?'#f28482':($c['status']=='finalizado'?'#90db9a':($c['status']=='atendimento'?'#f9c74f':'#6ea8fe')) ?>",

                extendedProps: {
                    dentista: <?= json_encode($c['dentista'] ?? '') ?>
                }
            }

            <?= $i < count($consultas)-1 ? ',' : '' ?>

            <?php endforeach; ?>

        ],

        eventContent: function(arg){

            let hora = arg.event.start.toLocaleTimeString([], {
                hour: '2-digit',
                minute:'2-digit'
            });

            let paciente = arg.event.title;
            let dentista = arg.event.extendedProps.dentista || '';

            if(paciente.length > 20){
                paciente = paciente.substring(0,20) + '...';
            }

            return {
                html: `
                <div style="font-size:11px; line-height:1.2">
                    <strong>${hora}</strong> ${paciente}<br>
                    <span style="opacity:0.7">${dentista}</span>
                </div>
                `
            };
        }

    });

    calendar.render();

});

function alterarStatus(id,status){

    fetch("<?= BASE_URL ?>/consultas/status",{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body: JSON.stringify({id,status})
    })
    .then(r=>r.json())
    .then(r=>{
        if(r.success){
            location.reload();
        }else{
            alert("Erro ao atualizar status");
        }
    });

}

</script>