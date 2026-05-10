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
<div class="card border-primary shadow-sm text-center p-2">
<h6>Consultas Hoje</h6>
<h3><?= $estatisticas['total'] ?? 0 ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card border-warning shadow-sm text-center p-2">
<h6>Em Atendimento</h6>
<h3><?= $estatisticas['atendimento'] ?? 0 ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card border-success shadow-sm text-center p-2">
<h6>Finalizadas</h6>
<h3><?= $estatisticas['finalizado'] ?? 0 ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card border-danger shadow-sm text-center p-2">
<h6>Faltaram</h6>
<h3><?= $estatisticas['faltou'] ?? 0 ?></h3>
</div>
</div>

</div>


<!-- LEGENDA -->

<div class="mb-3 d-flex gap-2 flex-wrap">

<button class="btn btn-sm btn-secondary filtro-status"
        data-status="todos">
    Todos
</button>

<button class="btn btn-sm filtro-status text-white"
        data-status="agendado"
        style="background:#6ea8fe">
    Agendado
</button>

<button class="btn btn-sm filtro-status text-white"
        data-status="confirmado"
        style="background:#43aa8b">
    Confirmado
</button>

<button class="btn btn-sm filtro-status text-dark"
        data-status="atendimento"
        style="background:#f9c74f">
    Atendimento
</button>

<button class="btn btn-sm filtro-status text-white"
        data-status="finalizado"
        style="background:#90db9a">
    Finalizado
</button>

<button class="btn btn-sm filtro-status text-white"
        data-status="faltou"
        style="background:#f28482">
    Faltou
</button>

<button class="btn btn-sm filtro-status text-white"
        data-status="cancelado"
        style="background:#6c757d">
    Cancelado
</button>

<button class="btn btn-sm filtro-status text-white"
        data-status="reagendado"
        style="background:#9d4edd">
    Reagendado
</button>

</div>


<!-- CALENDÁRIO -->

<div class="card shadow-sm">
<div class="card-body">
<div id="calendar"></div>
</div>
</div>


<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- 🔥 ESSENCIAL PARA TRADUÇÃO -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales-all.global.min.js"></script>

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

        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia'
        },

        allDayText: 'Período',

        height: 'auto',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        slotMinTime: '08:00:00',
        slotMaxTime: '21:00:00',

        editable: true,

        dateClick: function(info){

            const data = info.dateStr.substring(0,10);
            const hora = info.dateStr.substring(11,16);

            window.location =
            "<?= BASE_URL ?>/consultas/criar?data=" + data + "&hora=" + hora;

        },

        eventClick: function(info){

            const id = info.event.id;

            Swal.fire({

                title: info.event.title,

                html: `

                    <div class="d-grid gap-2 mt-3">

                        <button id="btnConfirmar"
                                class="btn btn-success">
                            ✅ Confirmar
                        </button>

                        <button id="btnReagendar"
                                class="btn btn-warning">
                            🔄 Reagendar
                        </button>

                        <button id="btnCancelar"
                                class="btn btn-danger">
                            ❌ Cancelar
                        </button>

                        <hr>

                        <button id="btnWhatsapp"
                                class="btn btn-success">
                            <i class="bi bi-whatsapp"></i>
                            WhatsApp
                        </button>

                        <button id="btnAtendimento"
                                class="btn btn-primary">
                            🩺 Atendimento
                        </button>

                    </div>

                `,

                showConfirmButton: false,

                didOpen: function(){

                    // CONFIRMAR
                    document.getElementById('btnConfirmar')
                    ?.addEventListener('click', function(){

                        alterarStatus(id,'confirmado');

                    });

                    // REAGENDAR
                    document.getElementById('btnReagendar')
                    ?.addEventListener('click', function(){

                        alterarStatus(id,'reagendado');

                    });

                    // CANCELAR
                    document.getElementById('btnCancelar')
                    ?.addEventListener('click', function(){

                        alterarStatus(id,'cancelado');

                    });

                    // ATENDIMENTO
                    document.getElementById('btnAtendimento')
                    ?.addEventListener('click', function(){

                        window.location =
                        "<?= BASE_URL ?>/consultas/iniciar/" + id;

                    });

                    // WHATSAPP
                    document.getElementById('btnWhatsapp')
                    ?.addEventListener('click', function(){

                        const telefone =
                            info.event.extendedProps.telefone || '';

                        let data =
                            info.event.extendedProps.data || '';

                        if(data.includes('-')){

                            const partes = data.split('-');

                            data =
                                partes[2] + '/' +
                                partes[1] + '/' +
                                partes[0];
                        }

                        const hora =
                            info.event.extendedProps.hora || '';

                        const paciente =
                            info.event.title || '';

                        const mensagem =
`Olá ${paciente} 😊

Podemos confirmar sua consulta odontológica para:

📅 Data: ${data}
⏰ Horário: ${hora}

Por favor responda:

1️⃣ Confirmar
2️⃣ Cancelar
3️⃣ Remarcar

Obrigado 🙂`;

                        const url =
'https://wa.me/55' +
telefone.replace(/\D/g,'') +
'?text=' +
encodeURIComponent(mensagem);

                        window.open(url, '_blank');

                    });

                }

            });

        },

        eventDrop: function(info){

            const id = info.event.id;

            const data = info.event.start.toISOString().substring(0,10);
            const hora = info.event.start.toTimeString().substring(0,5);

            fetch("<?= BASE_URL ?>/consultas/mover", {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json'
                },

                body: JSON.stringify({
                    id,
                    data,
                    hora
                })

            })
            .then(r => r.json())
            .then(r => {

                if(!r.success){

                    alert('Erro ao mover');
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

                color: "<?=

                    $c['status']=='faltou'
                        ? '#f28482'

                    : ($c['status']=='finalizado'
                        ? '#90db9a'

                    : ($c['status']=='atendimento'
                        ? '#f9c74f'

                    : ($c['status']=='confirmado'
                        ? '#43aa8b'

                    : ($c['status']=='cancelado'
                        ? '#6c757d'

                    : ($c['status']=='reagendado'
                        ? '#9d4edd'

                    : '#6ea8fe'))))) ?>",

                extendedProps: {

                    status: <?= json_encode($c['status'] ?? '') ?>,

                    dentista: <?= json_encode($c['dentista'] ?? '') ?>,

                    telefone: <?= json_encode($c['telefone'] ?? '') ?>,

                    data: <?= json_encode($c['data'] ?? '') ?>,

                    hora: <?= json_encode($c['hora'] ?? '') ?>

                }

            }

            <?= $i < count($consultas)-1 ? ',' : '' ?>

            <?php endforeach; ?>

        ],

        eventContent: function(arg){

            let hora = arg.event.start.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            let paciente = arg.event.title;
            let dentista = arg.event.extendedProps.dentista || '';

            if(paciente.length > 20){
                paciente = paciente.substring(0,20) + '...';
            }

            return {

                html: `

                    <div style="font-size:11px; line-height:1.2">

                        <strong>${hora}</strong> ${paciente}

                        <i class="bi bi-whatsapp text-success"
                           style="font-size:11px;"></i><br>

                        <span style="opacity:0.7">
                            ${dentista}
                        </span>

                    </div>

                `

            };

        }

});

// FILTROS
document
.querySelectorAll('.filtro-status')
.forEach(btn => {

    btn.addEventListener('click', function(){

        const status = this.dataset.status;

        calendar.getEvents().forEach(event => {

            if(status === 'todos'){

                event.setProp('display', 'auto');

            }else{

                const statusEvento =
                    event.extendedProps.status;

                event.setProp(
                    'display',
                    statusEvento === status
                        ? 'auto'
                        : 'none'
                );

            }

        });

    });

});

calendar.render();

});

function alterarStatus(id,status){

    fetch("<?= BASE_URL ?>/consultas/status", {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json'
        },

        body: JSON.stringify({
            id,
            status
        })

    })
    .then(r => r.json())
    .then(r => {

        if(r.success){

            location.reload();

        }else{

            alert('Erro ao atualizar status');

        }

    });

}

</script>