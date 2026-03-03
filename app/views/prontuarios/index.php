<h4 class="mb-4">Prontuário do Paciente</h4>

<input type="hidden" id="paciente_id" value="<?= $paciente['id'] ?>">

<div class="row">

    <!-- ================= ODONTOGRAMA ================= -->
    <div class="col-md-8">

        <div class="mb-3">
            <label><strong>Tipo de Dentição:</strong></label>
            <select id="tipoDenticao" class="form-select" style="max-width:250px;">
                <option value="permanente">Permanente</option>
                <option value="deciduo">Decíduo</option>
            </select>
        </div>

        <!-- PERMANENTE -->
        <div id="odontograma-permanente" class="odontograma">

            <img src="<?= BASE_URL ?>/assets/img/dentesperm.png" class="img-fluid">

            <!-- EXEMPLO DENTE 11 -->
            <div class="tooth" data-dente="11" style="top:50px; left:600px;">

                <div class="face vestibular" data-face="V"></div>
                <div class="face lingual" data-face="L"></div>
                <div class="face mesial" data-face="M"></div>
                <div class="face distal" data-face="D"></div>
                <div class="face oclusal" data-face="O"></div>

            </div>

        </div>

        <!-- DECÍDUO -->
        <div id="odontograma-deciduo" class="odontograma d-none">
            <img src="<?= BASE_URL ?>/assets/img/dentesdec.png" class="img-fluid">
        </div>

    </div>

    <!-- ================= PAINEL LATERAL ================= -->
    <div class="col-md-4">

        <div class="card mb-4">
            <div class="card-body">
                <h5>🦷 Dente Selecionado</h5>
                <p id="infoDente">Nenhum selecionado</p>

                <label>Procedimento:</label>
                <select id="procedimento" class="form-control mb-2">
                    <option value="">Selecione</option>
                    <option value="carie">Cárie</option>
                    <option value="restauracao">Restauração</option>
                    <option value="extracao">Extração</option>
                    <option value="canal">Tratamento de Canal</option>
                </select>

                <label>Observações:</label>
                <textarea id="observacoes" class="form-control" rows="3"></textarea>

                <button id="salvarRegistro" class="btn btn-success mt-2 w-100">
                    Salvar
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5>📸 Imagens / Radiografias</h5>
                <input type="file" class="form-control mb-2">
                <div style="height:120px; background:#f3f4f6; border-radius:8px;"></div>
            </div>
        </div>

    </div>

</div>


<!-- ================= ÁREA INFERIOR ================= -->

<hr class="my-5">

<div class="row">

    <!-- EVOLUÇÃO CLÍNICA -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>📅 Evolução Clínica</h5>

                <textarea class="form-control mb-3" rows="4"
                          placeholder="Registrar evolução do atendimento..."></textarea>

                <button class="btn btn-primary w-100">
                    Adicionar Evolução
                </button>

                <div class="mt-3" style="max-height:200px; overflow:auto;">
                    <small class="text-muted">
                        Nenhuma evolução registrada.
                    </small>
                </div>

            </div>
        </div>
    </div>

    <!-- PLANO DE TRATAMENTO -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>📋 Plano de Tratamento</h5>

                <textarea class="form-control mb-3" rows="4"
                          placeholder="Descrever plano odontológico do paciente..."></textarea>

                <button class="btn btn-success w-100">
                    Salvar Plano
                </button>

                <div class="mt-3">
                    <small class="text-muted">
                        Nenhum plano cadastrado.
                    </small>
                </div>

            </div>
        </div>
    </div>

</div>



<!-- ================= JAVASCRIPT ================= -->

<script>

document.addEventListener("DOMContentLoaded", function(){

    let denteSelecionado = null;
    let faceSelecionada = null;

    const tipoDenticao = document.getElementById("tipoDenticao");
    const odontogramaPerm = document.getElementById("odontograma-permanente");
    const odontogramaDec = document.getElementById("odontograma-deciduo");
    const infoDente = document.getElementById("infoDente");
    const btnSalvar = document.getElementById("salvarRegistro");

    /* ================= ALTERAR DENTIÇÃO ================= */
    if(tipoDenticao){
        tipoDenticao.addEventListener("change", function(){

            const tipo = this.value;

            odontogramaPerm.classList.add("d-none");
            odontogramaDec.classList.add("d-none");

            if(tipo === "permanente"){
                odontogramaPerm.classList.remove("d-none");
            } else {
                odontogramaDec.classList.remove("d-none");
            }

        });
    }

    /* ================= CLIQUE NAS FACES ================= */
    document.querySelectorAll(".face").forEach(function(face){

        face.addEventListener("click", function(e){

            e.stopPropagation();

            document.querySelectorAll(".face").forEach(f => f.classList.remove("ativo"));

            this.classList.add("ativo");

            const tooth = this.closest(".tooth");

            denteSelecionado = tooth.dataset.dente;
            faceSelecionada = this.dataset.face;

            infoDente.innerText =
                "Dente: " + denteSelecionado + " | Face: " + faceSelecionada;

        });

    });

    /* ================= SALVAR ================= */
    if(btnSalvar){
        btnSalvar.addEventListener("click", function(){

            if(!denteSelecionado){
                alert("Selecione uma face primeiro");
                return;
            }

            const procedimento = document.getElementById("procedimento").value;
            const obs = document.getElementById("observacoes").value;

            alert(
                "Salvar:\nDente: " + denteSelecionado +
                "\nFace: " + faceSelecionada +
                "\nProcedimento: " + procedimento +
                "\nObs: " + obs
            );

        });
    }

});
</script>