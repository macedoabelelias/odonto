

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

<!-- ÍCONE NO NAVEGADOR -->

<link rel="icon" href="<?= BASE_URL ?>/assets/img/favicon.ico">
<link rel="shortcut icon" href="<?= BASE_URL ?>/assets/img/favicon.ico">
<link rel="apple-touch-icon" href="<?= BASE_URL ?>/assets/img/favicon.png">


<h4 class="mb-4">🦷 Prontuário do Paciente</h4>

<div class="alert alert-info d-flex justify-content-between align-items-center flex-wrap">

    <!-- 🔥 FOTO + DADOS -->
    <div class="d-flex align-items-center gap-3 mb-2 mb-md-0">

        <?php
            $foto = $paciente['foto'] ?? null;
            $caminhoFoto = BASE_PATH . "/public/uploads/pacientes/" . $foto;
            $urlFoto = BASE_URL . "/uploads/pacientes/" . $foto;
        ?>

        <!-- FOTO -->
        <div id="fotoPaciente">
           <?php if(!empty($paciente['foto'])): ?>           
                <img src="<?= BASE_URL ?>/uploads/<?= $paciente['foto'] ?>" 
                    style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:2px solid #ddd;">
            <?php endif; ?>
        </div>

        <!-- DADOS -->
        <div>

            <strong>Paciente:</strong> 
            <span id="nomePaciente">
                <?= htmlspecialchars($paciente['nome'] ?? '') ?>
            </span> |

            <strong>Telefone:</strong> 
            <?= htmlspecialchars($paciente['telefone'] ?? '') ?> |

            <strong>Convênio:</strong> 
            <?= htmlspecialchars($paciente['convenio'] ?? '') ?>

            <input type="hidden" id="paciente_id" value="<?= $paciente['id'] ?? '' ?>">

        </div>

    </div>

    <!-- 🔥 BOTÕES -->
    <div class="d-flex gap-2 flex-wrap">

        <a href="<?= BASE_URL ?>/anamnese/index/<?= $paciente['id'] ?? '' ?>" 
           class="btn btn-primary btn-sm">
            🩺 Anamnese
        </a>

        <a href="<?= BASE_URL ?>/pacientes" 
           class="btn btn-secondary btn-sm">
            ← Voltar
        </a>

    </div>

</div>



<div class="row">

<!-- ODONTOGRAMA -->

<div class="col-lg-9" style="border-radius:14px;">

<div class="card shadow-sm mb-4" style="margin-top:20px;">

<div class="card-body text-center" style="box-shadow:0 2px 8px rgba(2,0,0,1.2)">

<label><strong>Tipo de Dentição</strong></label>

<select id="tipoDenticao" class="form-select mb-3" style="max-width:250px;margin:auto">
<option value="permanente">Permanente</option>
<option value="deciduo">Decíduo</option>
</select>

<div id="odontograma"
    style="position:relative;margin:auto;display:inline-block;">


        <img id="imgOdontograma"
        src="<?= BASE_URL ?>/assets/img/odontograma/dentesperm.png"
        style="width:680px;display:block;margin:auto;">

</div>

<hr>

<!-- ================= PROCEDIMENTOS GERAIS ================= -->
 
<div id="procedimentosGerais" style="margin-top:15px;">

    <h6 style="margin-bottom:10px; font-size:14px;">
        🧩 Procedimentos Gerais
    </h6>

    <div id="areaProcedimentosGerais"
         style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center; min-height:40px;">

        <!-- 🔥 AGORA FICA VAZIO -->
        <!-- Os itens serão adicionados via JavaScript -->

    </div>

</div>



<!-- TOOLTIP -->
<div id="tooltipDente"
style="
position:absolute;
background:white;
border:1px solid #ccc;
padding:6px 8px;
font-size:12px;
border-radius:6px;
display:none;
box-shadow:0 2px 6px rgba(0,0,0,0.2);
z-index:999;
pointer-events:none;
">
</div>

</div>
</div>
</div>


<!-- LATERAL -->
<div class="col-lg-3">
    <div class="card shadow-sm">
        <div class="card-body">

            <h6>🦷 Procedimento</h6>

            <select id="procedimentoSelect" name="procedimento_id" class="form-control mb-2">
                <option value="">Selecione</option>

                <?php if(!empty($procedimentos)): ?>
                    <?php foreach($procedimentos as $p): ?>

                        <?php
                            // 🔥 VALOR SEGURO
                            $valor = !empty($p['valor_particular']) 
                                ? $p['valor_particular'] 
                                : ($p['valor'] ?? 0);

                            // 🔥 GARANTE NÚMERO
                            $valor = floatval($valor);
                        ?>

                        <option 
                            value="<?= $p['id'] ?>"
                            data-valor="<?= $valor ?>"
                            data-nome="<?= htmlspecialchars($p['nome']) ?>"
                            data-icone="<?= htmlspecialchars($p['icone'] ?? '') ?>"
                        >
                            <?= htmlspecialchars($p['nome']) ?>
                        </option>

                    <?php endforeach; ?>
                <?php endif; ?>

            </select>

            <!-- VALOR -->
            <label>Valor</label>
            <input type="text" id="valorProcedimento" class="form-control mb-2" readonly>

            <!-- DENTE -->
            <input type="hidden" id="denteSelecionado">

            <label>Dente selecionado</label>
            <input type="text" id="denteVisual" class="form-control mb-2" readonly>

            <!-- STATUS -->
            <label>Status</label>
            <select id="statusProcedimento" name="status" class="form-control mb-2">

                <option value="planejado">A realizar</option>

                <!-- 🔥 IMPORTANTE: NÃO INCENTIVAR "realizado" aqui -->
                <option value="andamento">Em andamento</option>

                <option value="existente">Existente</option>
                <option value="cancelado">Cancelado</option>

                <!-- 🔥 opcional manter -->
                <option value="realizado">Realizado</option>

            </select>

            <!-- FACE -->
            <label>Face do dente</label>
            <select id="faceSelecionada" class="form-control mb-2">

                <option value="">Dente inteiro</option>
                <option value="oclusal">O</option>
                <option value="mesial">M</option>
                <option value="distal">D</option>
                <option value="vestibular">V</option>                
                <option value="lingual/palatino">L / P</option>
                <option value="mesio-distal">MD</option>
                <option value="ocluso-mesial">OM</option>
                <option value="ocluso-distal">OD</option>
                <option value="ocluso-mesio-distal">MOD</option>
                <option value="ocluso-vestibular">OV</option>
                <option value="ocluso-palatino">OP</option>

            </select>

            <!-- OBS -->
            <textarea id="observacoes" class="form-control mb-2"
                placeholder="Observações"></textarea>

            <!-- BOTÕES -->
            <button type="button" id="adicionarOrcamento" class="btn btn-primary w-100 mb-2">
                Adicionar ao Orçamento
            </button>

            <button type="button" id="removerRegistro" class="btn btn-danger w-100">
                Remover
            </button>

        </div>
    </div>
</div> <!-- FECHA COLUNA LATERAL -->

</div> <!-- FECHA ROW PRINCIPAL -->


<!-- ================= CARDS INFERIORES ================= -->

<!-- ================= PRIMEIRA LINHA ================= -->

<div class="row g-3 mt-3 linha-cards">

<!-- ORÇAMENTO -->
<div class="col-md-3">
<div class="card card-compact shadow-sm">
<div class="card-body">

<h6 class="card-title">💰 Orçamento</h6>
<hr>

<div id="listaOrcamento" style="max-height:150px; overflow:auto; font-size:13px;">
    Nenhum item
</div>

<div class="mt-2">

    <!-- 🔥 LINHA 1 -->
    <div class="d-flex gap-1 mb-1">
        <button id="salvarOrcamento" class="btn btn-success w-50">
            💾 Salvar
        </button>

        <button onclick="aprovarOrcamento()" class="btn btn-primary w-50">
            ✅ Aprovar
        </button>
    </div>

    <!-- 🔥 LINHA 2 -->
    <div class="d-flex gap-1 mb-1">
        <button id="editarOrcamento" class="btn btn-warning w-50">
            ✏️ Editar
        </button>

        <button id="novoOrcamento" class="btn btn-secondary w-50">
            🆕 Novo
        </button>
    </div>

    <!-- 🔥 LINHA 3 -->
    <button id="limparOrcamento" class="btn btn-danger w-100">
        🗑️ Limpar Orçamento
    </button>

</div>

<hr>

<strong>Total: R$ <span id="totalOrcamento">0.00</span></strong>

</div>
</div>
</div>


<!-- DOCUMENTOS -->

<div class="col-md-3">

<div class="card shadow-sm card-compacto h-100">

<div class="card-body p-2">

<h6>📂 Documentos</h6>

<!-- BLOCO COM SCROLL -->
<div style="max-height:160px; overflow:auto;">

<!-- CLÍNICOS -->
<small style="font-size:13px;color:#6b7280;">Clínicos</small>

<a href="<?= BASE_URL ?>/documentos/receita_form/<?= $paciente['id'] ?>" 
class="btn btn-outline-primary btn-sm w-100 mb-1">
<span class="me-2">💊</span> Receita

</a>

<a href="<?= BASE_URL ?>/documentos/atestado_form/<?= $paciente['id'] ?>"
class="btn btn-outline-secondary btn-sm w-100 mb-1">
<span class="me-2">📝</span> Atestado
</a>

<a href="<?= BASE_URL ?>/documentos/encaminhamento_form/<?= $paciente['id'] ?>"
class="btn btn-outline-dark btn-sm w-100 mb-2">
<span class="me-2">📄</span> Encaminhamento
</a>

<hr class="my-1">

<!-- JURÍDICOS -->
<small style="font-size:13px;color:#6b7280;">Jurídicos</small>

<a href="<?= BASE_URL ?>/documentos/contrato_form/<?= $paciente['id'] ?>"
class="btn btn-outline-dark btn-sm w-100 mb-2">
<span class="me-2">⚖️</span> Contrato
</a>

<a href="<?= BASE_URL ?>/documentos/consentimento_form/<?= $paciente['id'] ?>"
class="btn btn-outline-dark btn-sm w-100 mb-2">
<span class="me-2">📄</span>  Consentimento
</a>

</div>

<hr>

<!-- UPLOAD -->

<form method="POST"
action="<?= BASE_URL ?>/documentos/upload"
enctype="multipart/form-data">

<input type="hidden"
name="paciente_id"
value="<?= $paciente['id'] ?>">

<input type="file"
name="arquivo"
class="form-control form-control-sm mb-2">

<button class="btn btn-primary btn-sm w-100">
Enviar documento
</button>

</form>

<hr>

<!-- LISTA -->

<div style="max-height:100px;overflow:auto">

<?php if(!empty($documentos)): ?>

<?php foreach($documentos as $doc): ?>

<div style="font-size:12px;margin-bottom:4px;display:flex;justify-content:space-between;align-items:center;">

<span style="font-size:11px;">
<?= $doc['nome_arquivo'] ?>
</span>

<a href="<?= BASE_URL ?>/uploads/documentos/<?= $doc['arquivo'] ?>"
target="_blank"
class="btn btn-sm btn-outline-primary py-0 px-2">
Ver
</a>

</div>

<?php endforeach; ?>

<?php else: ?>

<span style="font-size:12px;color:#777">
Nenhum documento
</span>

<?php endif; ?>

</div>

</div>
</div>

</div>



<!-- RADIOGRAFIAS -->
<div class="col-md-3">
<div class="card shadow-sm card-compacto h-100">
<div class="card-body p-2">

<h6>📸 Radiografias</h6>

<input type="file" id="arquivoRX" class="form-control mb-2">

<button type="button" id="uploadRX"
class="btn btn-primary btn-sm w-100 mb-2">
Enviar Radiografia
</button>

<div id="listaRX"
style="max-height:120px;overflow:auto;background:#eef2f7;border-radius:8px;padding:8px;font-size:13px">

<?php if(isset($radiografias) && count($radiografias) > 0): ?>

<?php foreach($radiografias as $rx): ?>

<div style="display:inline-block;position:relative;margin:4px">

<img
src="<?= BASE_URL ?>/uploads/radiografias/<?= $rx['arquivo'] ?>"
style="width:60px;height:60px;object-fit:cover;border-radius:6px;cursor:pointer"
onclick="window.open(this.src)"
title="Clique para ampliar"
>

<button
onclick="excluirRX(<?= $rx['id'] ?>)"
style="
position:absolute;
top:-6px;
right:-6px;
background:#dc3545;
color:#fff;
border:none;
border-radius:50%;
width:18px;
height:18px;
font-size:12px;
cursor:pointer;
line-height:16px;
padding:0;
">



</button>

</div>

<?php endforeach; ?>

<?php else: ?>

<span style="color:#777">Nenhuma radiografia</span>

<?php endif; ?>

</div>

</div>
</div>
</div>


<!-- LEGENDA -->
<div class="col-md-3">
    <div class="card card-padrao h-100">
        <div class="card-body p-2">

            <h6 class="mb-2">🦷 Legenda do Odontograma</h6>
            <hr>

            <div class="d-flex flex-column gap-2">

                <!-- 🔴 A REALIZAR -->
                <div class="d-flex align-items-center gap-2">
                    <div style="width:14px;height:14px;background:#F44336;border-radius:4px;"></div>
                    <span class="small">A realizar</span>
                </div>

                <!-- 🔵 REALIZADO -->
                <div class="d-flex align-items-center gap-2">
                    <div style="width:14px;height:14px;background:#2196F3;border-radius:4px;"></div>
                    <span class="small">Realizado</span>
                </div>

                <!-- ⚫ EXISTENTE -->
                <div class="d-flex align-items-center gap-2">
                    <div style="width:14px;height:14px;background:#9E9E9E;border-radius:4px;"></div>
                    <span class="small">Existente</span>
                </div>

                <!-- 🟡 EM ANDAMENTO -->
                <div class="d-flex align-items-center gap-2">
                    <div style="width:14px;height:14px;background:#FFC107;border-radius:4px;"></div>
                    <span class="small">Em andamento</span>
                </div>

                <!-- 🟣 CANCELADO -->
                <div class="d-flex align-items-center gap-2">
                    <div style="width:14px;height:14px;background:#9C27B0;border-radius:4px;"></div>
                    <span class="small">Cancelado</span>
                </div>

            </div>

            <!-- 🔥 NOVA SEÇÃO -->
            <hr class="my-2">

            <h6 class="mb-2">📄 Documentos do Paciente</h6>

            <div style="max-height:220px; overflow-y:auto;">

                <?php if(!empty($historicoPDFs)): ?>

                    <?php foreach($historicoPDFs as $pdf): ?>

                        <div class="d-flex justify-content-between align-items-center mb-1">

                            <span style="font-size:11px;">
                                <?= $pdf['tipo'] ?><br>
                                <small><?= date('d/m H:i', strtotime($pdf['data_upload'])) ?></small>
                            </span>

                            <a href="<?= BASE_URL ?>/uploads/<?= $pdf['arquivo'] ?>" 
                               target="_blank" 
                               class="btn btn-sm btn-primary py-0 px-2">
                                Ver
                            </a>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>
                    <span class="small text-muted">Nenhum documento</span>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>



<!-- ================= SEGUNDA LINHA ================= -->

<div class="row g-3 mt-3 linha-cards">

<!-- PLANO DE TRATAMENTO -->
<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body p-2">

<h6 class="card-title">🦷 Plano de Tratamento</h6>

<div style="max-height:150px; overflow-y:auto;">

<?php if(!empty($plano)): ?>
    <?php foreach($plano as $p): ?>

        <?php $statusAtual = $p['status'] ?? 'planejado'; ?>

        <div class="border rounded p-2 mb-2">

            <strong style="font-size:13px;">
                <?= htmlspecialchars($p['procedimento']) ?>
            </strong>

            <br>

            <small class="text-muted">
                Dente <?= htmlspecialchars($p['dente'] ?? '-') ?>
            </small>

            <br>

            <small>
                R$ <?= isset($p['valor']) ? number_format($p['valor'],2,',','.') : '0,00' ?>
            </small>

            <!-- 🔥 STATUS -->
            <form method="POST" action="<?= BASE_URL ?>/index.php?url=plano/atualizarStatus">

                <input type="hidden" name="id" value="<?= $p['id'] ?>">

                <select name="status"
                    onchange="this.form.submit()"
                    class="form-select form-select-sm mt-1">

                    <option value="planejado" <?php if($statusAtual == 'planejado') echo 'selected="selected"'; ?>>
                        Planejado
                    </option>

                    <option value="andamento" <?php if($statusAtual == 'andamento') echo 'selected="selected"'; ?>>
                        Em andamento
                    </option>

                    <option value="realizado" <?php if($statusAtual == 'realizado') echo 'selected="selected"'; ?>>
                        Realizado
                    </option>

                    <option value="cancelado" <?php if($statusAtual == 'cancelado') echo 'selected="selected"'; ?>>
                        Cancelado
                    </option>

                </select>

            </form>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <span class="text-muted small">Nenhum procedimento no plano.</span>

<?php endif; ?>

</div>

<button id="salvarPlano" class="btn btn-success w-100 mb-1 mt-2">
Salvar Plano
</button>

<!-- 🔥 BOTÕES PDF -->
<div class="d-grid gap-1 mt-2">

    <button onclick="gerarPDFPlano()" class="btn btn-outline-primary btn-sm">
        📄 PDF Plano
    </button>

    <button onclick="gerarPDFProntuario()" class="btn btn-dark btn-sm">
        🗂️ PDF Prontuário
    </button>

</div>

</div>
</div>
</div>

<!-- 🔥 ÁREA DO PDF (CORRIGIDA) -->
<div id="areaPDF" style="display:none; padding:20px; font-family:Arial;">

    <h2 style="text-align:center;">Plano de Tratamento Odontológico</h2>

    <hr>

    <div id="pdfFoto" style="margin-bottom:10px;"></div>

    <p><strong>Paciente:</strong> <span id="pdfPaciente"></span></p>
    <p><strong>CPF:</strong> <span id="pdfCpfPaciente"></span></p>

    <p><strong>Profissional:</strong> <span id="pdfProfissional"></span></p>
    <p><strong>CPF:</strong> <span id="pdfCpfProfissional"></span></p>
    <p><strong>CRO:</strong> <span id="pdfCRO"></span></p>

    <p><strong>Data:</strong> <span id="pdfData"></span></p>

    <hr>

    <h4>Plano de Tratamento</h4>
    <div id="pdfPlano"></div>

    <h4 style="margin-top:20px;">Odontograma</h4>
    <div id="pdfOdontograma"></div>

    <div id="pdfEvolucao"></div>

    <hr style="margin-top:30px;">

    <div style="display:flex; justify-content:space-between; margin-top:80px;">

    <div style="width:45%; text-align:center;">
        <div style="border-bottom:1px solid #000; height:40px;"></div>
        <p style="margin-top:5px;">Assinatura do Paciente / Responsável</p>
    </div>

    <div style="width:45%; text-align:center;">
        <div style="border-bottom:1px solid #000; height:40px;"></div>
        <p style="margin-top:5px;">Assinatura do Profissional</p>
    </div>

</div>

</div>


<!-- EVOLUÇÃO CLÍNICA -->
<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body p-2">

<h6 class="card-title">📋 Evolução Clínica</h6>

<!-- 🔥 HISTÓRICO -->
<div style="max-height:150px; overflow-y:auto;">

<?php if(!empty($evolucoes)): ?>

    <?php foreach($evolucoes as $e): ?>

        <div class="border rounded p-2 mb-2 bg-light">

            <strong style="font-size:13px;">
                <?= $e['procedimento_nome'] ?? 'Procedimento' ?>
            </strong>

            <br>

            <small class="text-muted">
                <?= ucfirst($e['status']) ?>
            </small>

            <?php if(!empty($e['observacao'])): ?>
                <div class="small mt-1">
                    <?= nl2br(htmlspecialchars($e['observacao'])) ?>
                </div>
            <?php endif; ?>

            <div class="text-end">
                <small class="text-muted">
                    <?= date('d/m/Y H:i', strtotime($e['data'])) ?>
                </small>
            </div>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <span class="text-muted small">Nenhuma evolução registrada.</span>

<?php endif; ?>

</div>

<hr class="my-2">

<!-- 🔥 NOVA EVOLUÇÃO (SOMENTE TEXTO) -->
<form method="POST" action="<?= BASE_URL ?>/evolucao/salvar">

<input type="hidden" name="paciente_id" value="<?= $paciente['id'] ?>">

<textarea name="observacao"
class="form-control mb-2"
rows="3"
placeholder="Registrar evolução clínica..."></textarea>

<button class="btn btn-primary w-100 btn-sm">
Salvar Evolução
</button>

</form>

</div>
</div>
</div>

<!-- RECOMENDAÇÕES -->
<div class="col-md-3">
<div class="card shadow-sm card-compacto h-100">
<div class="card-body p-2">

<h6>💡 Recomendações</h6>
<hr>

<strong>📅 Lembrete</strong>

<p class="small">
Profilaxia recomendada a cada 6 meses. Fazer agendamento para limpeza e prevenção.
</p>

<a href="<?= BASE_URL ?>/consultas/criar?paciente=<?= $paciente['id'] ?>"
class="btn btn-outline-primary btn-sm w-100">

📅 Agendar Retorno

</a>

</div>
</div>
</div>
<hr>

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

<div id="areaPDF" style="display:none;">

    <!-- 🔥 TÍTULO -->
    <h2 style="font-size:18px; margin-bottom:10px;">
        🦷 Prontuário do Paciente
    </h2>

    <!-- 🔥 DADOS -->
    <p>
        <strong>Paciente:</strong> <span id="pdfPaciente"></span><br>
        <strong>Data:</strong> <span id="pdfData"></span>
    </p>

    <hr>

    <!-- 🔥 ODONTOGRAMA -->
    <h4 style="font-size:14px;">🦷 Odontograma</h4>
    <div id="pdfOdontograma" style="margin-bottom:10px;"></div>

    <hr>

    <!-- 🔥 PLANO -->
    <h4 style="font-size:14px;">Plano de Tratamento</h4>
    <div id="pdfPlano" style="margin-bottom:10px;"></div>

    <hr>

    <!-- 🔥 EVOLUÇÃO -->
    <h4 style="font-size:14px;">Evolução Clínica</h4>
    <div id="pdfEvolucao" style="margin-bottom:10px;"></div>

    <hr>

    <!-- 🔥 DECLARAÇÃO -->
    <p style="margin-top:20px;">
        Declaro que fui informado(a) sobre o plano de tratamento, riscos,
        custos e alternativas, estando de acordo com os procedimentos propostos.
    </p>

    <!-- 🔥 ASSINATURAS -->
    <div style="display:flex; justify-content:space-between; margin-top:50px;">

        <div style="text-align:center;">
            _______________________________<br>
            Assinatura do Paciente
        </div>

        <div style="text-align:center;">
            _______________________________<br>
            Cirurgião-Dentista
        </div>

    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>

const BASE = "<?= BASE_URL ?>"; // ✅ AQUI

function getPacienteId(){
    let el = document.getElementById("paciente_id");
    if(!el) return null;
    return el.value;
}

let denteSelecionado = null;
let modoEdicao = false;

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

55:{x:23,y:108},54:{x:78,y:108},53:{x:128,y:108},52:{x:168,y:108},51:{x:213,y:108},
61:{x:280,y:108},62:{x:322,y:108},63:{x:364,y:108},64:{x:415,y:108},65:{x:472,y:108},

85:{x:25,y:166},84:{x:91,y:166},83:{x:142,y:162},82:{x:182,y:162},81:{x:220,y:162},
71:{x:274,y:162},72:{x:312,y:162},73:{x:350,y:162},74:{x:401,y:166},75:{x:468,y:162}

};


/* ================= TOOLTIP ================= */

function mostrarTooltipDente(dente,e){

    let paciente = document.getElementById("paciente_id")?.value;

    if(!paciente) return;

    fetch("<?= BASE_URL ?>/prontuarios/historicoDente",{

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body: JSON.stringify({
            paciente: paciente,
            dente: dente
        })

    })

    .then(res=>res.json())

    .then(data=>{

        let tooltip = document.getElementById("tooltipDente");

        if(!tooltip) return;

        let html = "<strong>Dente "+dente+"</strong><br>";

        if(!data || data.length===0){

            html += "Sem registros";

        }else{

            data.forEach(function(r){

                html += r.procedimento;

                if(r.face){
                    html += " "+r.face;
                }

                html += " ("+r.status+")<br>";

            });

        }

        tooltip.innerHTML = html;
        tooltip.style.left = (e.pageX+10)+"px";
        tooltip.style.top = (e.pageY+10)+"px";
        tooltip.style.display="block";

    });

}

/* ================= GERAR ODONTOGRAMA ================= */

function gerarOdontograma(mapa){

    const container = document.getElementById("odontograma");

    // 🔥 REMOVE DENTES ANTIGOS
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
        tooth.style.pointerEvents = "auto";

        // 🔥 CAMADA DE ÍCONES (IMPORTANTE)
        const camada = document.createElement("div");
        camada.className = "proc-layer";

        camada.style.position = "absolute";
        camada.style.left = "0";
        camada.style.top = "0";
        camada.style.width = "100%";
        camada.style.height = "100%";
        camada.style.pointerEvents = "none";

        tooth.appendChild(camada);

        /* TOOLTIP */
        tooth.addEventListener("mouseover", function(e){
            mostrarTooltipDente(dente, e);
        });

        tooth.addEventListener("mouseout", function(){
            document.getElementById("tooltipDente").style.display = "none";
        });

        /* CLICK NO DENTE */
        tooth.addEventListener("click", function(){

            let denteSelecionado = this.dataset.dente;

            document.getElementById("denteSelecionado").value = denteSelecionado;
            document.getElementById("denteVisual").value = denteSelecionado;

            document.querySelectorAll(".tooth").forEach(t => {
                t.classList.remove("tooth-ativo");
            });

            this.classList.add("tooth-ativo");

            // 🔥 Atualizações
            carregarHistoricoDente(denteSelecionado);
            carregarRXDente(denteSelecionado);

        });

        container.appendChild(tooth);

    });

}

/* ================= PINTAR DENTE ================= */
function pintarDente(dente, procedimento, status, iconeDB = null, idProcedimento = null){

    // 🔥 GARANTE STRING SEGURA
    let nomeOriginal = (procedimento || "Procedimento").trim();
    let nomeLower = nomeOriginal.toLowerCase();

    // 🔥 NORMALIZA STATUS
    let statusSafe = (status || "planejado")
        .toLowerCase()
        .trim()
        .normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    // 🔥 CORREÇÃO DE FLUXO (ESSENCIAL)
    // nunca deixa "aprovado" virar "realizado"
    if(statusSafe === "aprovado"){
        statusSafe = "andamento";
    }

    // 🔥 SEGURANÇA (status inválido)
    const statusValidos = ["planejado","andamento","realizado","cancelado","existente"];
    if(!statusValidos.includes(statusSafe)){
        statusSafe = "planejado";
    }

    const tooth = document.querySelector(".tooth[data-dente='"+dente+"']");
    if(!tooth){
        console.warn("Sem dente:", nomeOriginal);
        return;
    }

    const camada = tooth.querySelector(".proc-layer");
    if(!camada) return;

    // 🔥 ÍCONE
    let icone = iconeDB;
    if(!icone || icone === "" || icone === "null"){
        icone = getIconeProcedimento(nomeOriginal);
    }
    if(!icone || icone === "null" || icone === undefined){
        icone = "default.png";
    }

    let base = "<?= BASE_URL ?>/assets/img/procedimentos/";

    const procedimentosGerais = [
        "atm","profilaxia","consulta","condicionamento","clareamento","controle","emergencia",
        "enceramento","frenectomia_labial","frenectomia_lingual","gengivectomia","placa","protese_parcial","raspagem","selante","fotografia",
        "oclusal","interproximal","panoramica","periapical","fluor","overdenture","protese_total",
        "protocolo_implante","raspagem_subgengival","raspagem_supragengival","manutencao","modelo",
        "reembazamento","ulectomia","urgencia"
    ];

    if(procedimentosGerais.some(p => nomeLower.includes(p))){
        base = "<?= BASE_URL ?>/assets/img/procedimentos/gerais/";
    }

// 🔥 EVITA DUPLICADO
let existente = Array.from(camada.querySelectorAll("img"))
    .find(img => 
        (idProcedimento && String(img.dataset.id) === String(idProcedimento)) ||
        ((img.title || "").trim().toLowerCase() === nomeLower)
    );

if(existente){

    // 🔥 GARANTE STATUS SEGURO
    let statusFinal = (statusSafe || "planejado").toLowerCase().trim();

    // 🔥 REMOVE STATUS ANTIGO
    existente.classList.remove(
        "planejado",
        "realizado",
        "andamento",
        "cancelado",
        "existente"
    );

    // 🔥 APLICA NOVO STATUS
    existente.classList.add(statusFinal);

    // 🔥 ATUALIZA BANCO SOMENTE SE TIVER ID
    if(idProcedimento){

        fetch("<?= BASE_URL ?>/procedimentos/atualizarStatus", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                id: idProcedimento,
                status: statusFinal
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log("Status atualizado:", data);
        })
        .catch(err => {
            console.error("Erro ao atualizar status:", err);
        });
    }

    return;
}  

// 🔥 CRIA ÍCONE
const novoIcone = document.createElement("img");
novoIcone.src = base + icone;

novoIcone.className = "icone-procedimento " + statusSafe;
novoIcone.title = nomeOriginal;

// 🔥 PRIMEIRO DEFINE O ID (IMPORTANTE)
if(idProcedimento){
    novoIcone.dataset.id = idProcedimento;
}

// 🔥 CLICK = FINALIZAR PROCEDIMENTO
novoIcone.addEventListener("click", function(e){

    e.stopPropagation();

    if(!confirm("Finalizar procedimento?")) return;

    this.classList.remove("planejado","andamento","cancelado","existente");
    this.classList.add("realizado");

    if(this.dataset.id){
        fetch("<?= BASE_URL ?>/procedimentos/atualizarStatus", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                id: this.dataset.id,
                status: "realizado"
            })
        })
        .then(res => res.json())
        .then(data => {
            console.log("✔ Finalizado:", data);
        })
        .catch(err => {
            console.error("Erro:", err);
        });
    }

});



// 🔥 ERRO DE IMAGEM
novoIcone.onerror = function(){
    console.warn("❌ Ícone não encontrado:", this.src);
    this.style.display = "none";
};

// 🔥 ESTILO
novoIcone.style.position = "absolute";
novoIcone.style.width = "48px";
novoIcone.style.height = "48px";
novoIcone.style.zIndex = "30";

// 🔢 IDENTIFICA DENTE
let denteNum = parseInt(dente);
let isInferior = 
    (denteNum >= 31 && denteNum <= 48) ||
    (denteNum >= 71 && denteNum <= 85);

    // ================= REGRAS =================

    let nomeCheck = nomeLower
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");

    let ehCoroaImplante = 
        nomeCheck.includes("coroa_implante") || 
        nomeCheck.includes("coroa sobre implante");

    let ehNucleo = nomeCheck.includes("nucleo");
    let ehRaizResidual = nomeCheck.includes("raiz residual");

    let ehRaiz = 
        !ehCoroaImplante &&
        !ehNucleo &&
        (
            nomeCheck.includes("canal") ||
            nomeCheck.includes("endo") ||
            nomeCheck.includes("implante") ||
            ehRaizResidual
        );

    let ehCoroa = 
        !ehNucleo &&
        !ehCoroaImplante &&
        !ehRaiz &&
        (
            nomeCheck.includes("restaura") || 
            nomeCheck.includes("coroa")
        );

    // ================= POSICIONAMENTO =================

    if(isInferior){

        if(ehCoroaImplante){
            novoIcone.classList.add("icone-coroa-inferior");
        }
        else if(ehNucleo || ehRaizResidual || ehRaiz){
            novoIcone.classList.add("icone-raiz-inferior");
        }
        else if(ehCoroa){
            novoIcone.classList.add("icone-coroa-inferior");
        }
        else{
            novoIcone.classList.add("icone-centro");
        }

    }else{

        if(ehCoroaImplante){
            novoIcone.classList.add("icone-coroa");
        }
        else if(ehNucleo || ehRaizResidual || ehRaiz){
            novoIcone.classList.add("icone-raiz");
        }
        else if(ehCoroa){
            novoIcone.classList.add("icone-coroa");
        }
        else{
            novoIcone.classList.add("icone-centro");
        }

    }

    camada.appendChild(novoIcone);
}


// 4. MUDAR STATUS
function mudarStatus(dente, status){

    console.log("Mudando status:", dente, status);

    const tooth = document.querySelector(".tooth[data-dente='"+dente+"']");
    if(!tooth) return;

    const camada = tooth.querySelector(".proc-layer");
    if(!camada) return;

    const icones = camada.querySelectorAll("img");

    if(icones.length === 0){
        alert("Nenhum procedimento neste dente");
        return;
    }

    icones.forEach(icon => {

        // 🔥 REMOVE STATUS ANTIGO
        icon.classList.remove(
            "planejado",
            "realizado",
            "andamento",
            "cancelado",
            "existente"
        );

        // 🔥 APLICA NOVO STATUS
        icon.classList.add(status);

    });

    // 🔥 fecha menu
    let menu = document.getElementById("menuStatus");
    if(menu) menu.style.display = "none";
}


// ================= FIM =================


/* ================= COLOCAR ICONE NO DENTE ================= */

function colocarIconeNoDente(dente, procedimento){

    if(!procedimento) return;

    const tooth = document.querySelector(`.tooth[data-dente="${dente}"]`);
    if(!tooth) return;

    const layer = tooth.querySelector(".proc-layer");
    if(!layer) return;

    // 🔥 NORMALIZA
    let proc = procedimento.toLowerCase().trim();

    let arquivo = null;

    // 🔥 MATCH FLEXÍVEL (RESOLVE DE VEZ)
    if(proc.includes("canal")){
        arquivo = "canal.png";
    }
    else if(proc.includes("carie")){
        arquivo = "carie.png";
    }
    else if(proc.includes("cirurgia")){
        arquivo = "cirurgia.png";
    }
    else if(proc.includes("cirurgia1")){
        arquivo = "cirurgia1.png";
    }
    else if(proc.includes("coroa")){
        arquivo = "coroa.png";
    }
    else if(proc.includes("extracao") || proc.includes("exodontia") || proc.includes("remoção")){
        arquivo = "extracao.png";
    }
    else if(proc.includes("raiz_residual") || proc.includes("exodontia") || proc.includes("remoção")){
        arquivo = "raiz_residual.png";
    }
    else if(proc.includes("reembazamento_coroa")){
        arquivo = "reembazamento_coroa.png";
    }
    else if(proc.includes("ausente")){
        arquivo = "ausente.png";
    }

    else if(proc.includes("implante")){
        arquivo = "implante.png";
    }
    else if(proc.includes("nucleo")){
        arquivo = "nucleo.png";
    }
    else if(proc.includes("restaura") || proc.includes("obtura") || proc.includes("restauração")){
        arquivo = "restauracao.png";
    }

    if(!arquivo) {
        console.warn("Ícone não encontrado para:", procedimento);
        return;
    }

    let icon = document.createElement("img");
    icon.src = "/odonto/public/assets/img/procedimentos/gerais/" + arquivo;
    icon.classList.add("proc-icon");

    layer.appendChild(icon);
}


/* ================= HISTÓRICO PACIENTE ================= */

function carregarHistoricoPaciente(){

    let paciente = document.getElementById("paciente_id").value;

    fetch("<?= BASE_URL ?>/prontuarios/historicoPaciente/"+paciente)

    .then(res => res.json())

    .then(data => {

        let html = '';

        if(!data || data.length === 0){

            html = "Nenhum registro";

        } else {

            data.forEach(r => {

                html += `
                <div style="font-size:13px;margin-bottom:8px;border-bottom:1px solid #eee;padding-bottom:6px">
                    <strong>${new Date(r.data).toLocaleDateString()}</strong><br>
                    ${r.procedimento}
                    ${r.dente ? ' - Dente '+r.dente : ''}
                </div>
                `;

            });

        }

        // 🔥 CORREÇÃO PRINCIPAL
        let el = document.getElementById("timelinePaciente");

        if(el){
            el.innerHTML = html;
        }

    })

    .catch(err => {
        console.error("Erro ao carregar histórico:", err);
    });

}

/* ================= CARREGAR PROCEDIMENTOS ================= */

function carregarProcedimentos(){

    let pacienteInput = document.getElementById("paciente_id");
    if(!pacienteInput) return;

    let paciente = pacienteInput.value;
    if(!paciente) return;

    // 🔥 LIMPA ÍCONES
    document.querySelectorAll(".proc-layer").forEach(layer=>{
        layer.innerHTML = "";
    });

    fetch("<?= BASE_URL ?>/prontuarios/registros/" + paciente)

    .then(res => res.json())

    .then(dados => {

        console.log("DADOS:", dados); // 🔍 DEBUG

        if(!dados || !Array.isArray(dados)) return;

        dados.forEach(function(item){

            console.log("ITEM:", item); // 🔍 DEBUG

            if(!item.procedimento) return;

            // 🔥 GARANTE QUE TEM DENTE
        // 🔥 SE TEM DENTE → pinta no dente
            if(item.dente && item.dente !== "" && item.dente !== null){

            pintarDente(
                item.dente,
                item.procedimento,
                item.status,
                item.icone
            );

            }
            // 🔥 SE NÃO TEM DENTE → pinta como GERAL (EX: dente 0 ou 99)
            else{

                pintarDente(
                    0, // 🔥 usamos "0" como dente virtual
                    item.procedimento,
                    item.status || "planejado"
                );

            }   

        });

    })

    .catch(err=>{
        console.error("Erro ao carregar procedimentos:", err);
    });

}

/* ================= INICIAR SISTEMA ================= */

// 🔥 GARANTE QUE OS ELEMENTOS EXISTEM
const btnAdd = document.getElementById("adicionarOrcamento");
const selectProc = document.getElementById("procedimentoSelect");
const inputValor = document.getElementById("valorProcedimento");

// 🔥 ADICIONAR AO ORÇAMENTO + SALVAR NO PRONTUÁRIO

if(btnAdd){
    btnAdd.addEventListener("click", function(e){

        e.preventDefault();

        // 🔥 PEGA STATUS CORRETO DO SELECT
        let status = document.getElementById("statusProcedimento")?.value || "planejado";

        console.log("STATUS AO ADICIONAR:", status);

        let option = selectProc.selectedOptions[0];

        if(!option || option.value === ""){
            alert("Selecione um procedimento");
            return;
        }

        let paciente = document.getElementById("paciente_id").value;
        let nome = option.text;
        let valor = parseFloat(option.dataset.valor || inputValor.value || 0);
        let dente = document.getElementById("denteSelecionado")?.value || "";

        let ehGeral = (!dente || dente === "0");

        if(!ehGeral && (!dente || dente === "")){
            alert("Selecione um dente primeiro");
            return;
        }

        let existente = orcamento.find(item =>
            item.nome === nome && item.dente === dente
        );

        if(existente){

            existente.quantidade = (existente.quantidade || 1) + 1;

        } else {

            // 🔥 AQUI ESTÁ A CORREÇÃO REAL
            orcamento.push({
                nome: nome,
                valor: valor,
                dente: dente,
                quantidade: 1,
                status: String(status).toLowerCase().trim(), // ✅ AGORA VAI CERTO
                tipo: dente ? "dente" : "geral"
            });

        }

        atualizarOrcamento();


// 🔥 MOSTRAR PROCEDIMENTO GERAL NA TELA
if(!dente || dente == "" || dente == 0){

    const area = document.getElementById("areaProcedimentosGerais");

    if(area){

        let icone = getIconeProcedimento(nome) || "default.png";

        const div = document.createElement("div");

        div.style.display = "flex";
        div.style.alignItems = "center";
        div.style.gap = "6px";
        div.style.padding = "6px 10px";
        div.style.borderRadius = "8px";
        div.style.background = "#f1f5f9";
        div.style.fontSize = "12px";

        div.innerHTML = `
            <img src="<?= BASE_URL ?>/assets/img/procedimentos/gerais/${icone}" style="width:20px;height:20px;">
            <span>${nome}</span>
        `;

        area.appendChild(div);
    }
}

        // 🔥 SALVA NO PRONTUÁRIO (CORRIGIDO)
        fetch("<?= BASE_URL ?>/prontuarios/salvarRegistro",{

            method:"POST",

            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },

            body:`paciente_id=${paciente}&dente=${dente}&face=&procedimento=${option.value}&status=${status}&observacoes=`

        })
        .then(res=>res.json())
        .then(resp=>{

            if(resp.status === "ok"){
                console.log("Salvo no prontuário");

                // 🔥 ATUALIZA ODONTOGRAMA
                carregarProcedimentos();
            }else{
                console.warn("Erro ao salvar prontuário");
            }

        });

        // 🔥 LIMPA CAMPOS
        selectProc.selectedIndex = 0;
        inputValor.value = "";

    });

}

// 🔥 EVENTO CORRETO PARA PROCEDIMENTOS GERAIS
document.querySelectorAll(".proc-geral").forEach(item => {

    item.addEventListener("click", function(){

        let nome = this.dataset.nome;
        let valor = parseFloat(this.dataset.valor || 0);

        const selectProc = document.getElementById("procedimentoSelect");
        const inputValor = document.getElementById("valorProcedimento");
        const denteInput = document.getElementById("denteSelecionado");
        const denteVisual = document.getElementById("denteVisual");

        // limpa dente
        if(denteInput) denteInput.value = "";
        if(denteVisual) denteVisual.value = "Procedimento geral";

        // seleciona no select
        if(selectProc){
            for(let opt of selectProc.options){
                if(opt.text.trim() === nome.trim()){
                    opt.selected = true;
                    break;
                }
            }
        }

        // seta valor
        if(inputValor){
            inputValor.value = valor.toFixed(2);
        }

        // 🔥 REMOVE DA TELA
        this.remove();

    });

});

/* ================= TROCAR DENTIÇÃO ================= */

const tipoDenticao = document.getElementById("tipoDenticao");

if(tipoDenticao){

    tipoDenticao.addEventListener("change",function(){

        const tipo = this.value;
        const img = document.getElementById("imgOdontograma");

        if(tipo === "permanente"){

            img.src = "<?= BASE_URL ?>/assets/img/odontograma/dentesperm.png";
            img.style.width = "680px";

            gerarOdontograma(mapaPermanente);

        }else{

            img.src = "<?= BASE_URL ?>/assets/img/odontograma/dentesdec.png";
            img.style.width = "520px";

            gerarOdontograma(mapaDeciduo);

        }

        setTimeout(carregarProcedimentos,200);

    });

}


/*================ SALVAR ORÇAMENTO AUTO =================*/

function salvarOrcamentoAuto(){

    let paciente = document.getElementById("paciente_id").value;

    fetch("<?= BASE_URL ?>/orcamentos/salvar", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            paciente_id: paciente,
            itens: orcamento
        })

    })
    .then(res => res.text())
    .then(txt => {

        console.log("RESPOSTA RAW:", txt);
        console.log("Orçamento atualizado automaticamente");

        // 🔥 AQUI RESOLVE SEU PROBLEMA
        location.reload();

    })
    .catch(err => {
        console.error("Erro ao salvar automático:", err);
    });

}

const btnEditarOrc = document.getElementById("editarOrcamento");

if(btnEditarOrc){

    btnEditarOrc.addEventListener("click", function(){

        if(orcamento.length === 0){
            alert("Nenhum orçamento para editar");
            return;
        }

        modoEdicao = true;

        alert("Modo edição ativado.\nClique nos botões ✏️ para editar.");

    });

}

// ============Salvar Evolução Clínica ============

const btnEvolucao = document.getElementById("salvarEvolucao");

if(btnEvolucao){

    btnEvolucao.addEventListener("click", function(){

        let paciente = document.getElementById("paciente_id").value;
        let descricao = document.getElementById("textoEvolucao").value;

        fetch("<?= BASE_URL ?>/prontuarios/salvarEvolucao",{

            method:"POST",

            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },

            body:`paciente_id=${paciente}&descricao=${descricao}`

        })
        .then(res=>res.json())
        .then(data=>{

            if(data.status==="ok"){

                alert("Evolução registrada");

                document.getElementById("textoEvolucao").value='';

            }

        });

    });

}

// =============Plano de Tratamento ============

const btnPlano = document.getElementById("salvarPlano");

if(btnPlano){

    btnPlano.addEventListener("click", function(){

        let paciente = document.getElementById("paciente_id").value;
        let descricao = document.getElementById("textoPlano").value;

        fetch("<?= BASE_URL ?>/prontuarios/salvarPlano",{

            method:"POST",

            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },

            body:`paciente_id=${paciente}&descricao=${descricao}`

        })
        .then(res=>res.json())
        .then(data=>{

            if(data.status==="ok"){

                alert("Plano salvo");

                document.getElementById("textoPlano").value='';

            }

        });

    });

}


/* ================= CARREGAR RADIOGRAFIA POR DENTE ================= */

function carregarRXDente(dente){

    fetch("<?= BASE_URL ?>/radiografias/porDente?paciente=<?= $paciente['id'] ?>&dente="+dente)

    .then(r=>r.json())

    .then(lista=>{

        let div = document.getElementById("listaRX");

        if(!div) return;

        if(!lista || lista.length === 0){
            div.innerHTML = "Nenhuma radiografia para este dente";
            return;
        }

        let html = "";

        lista.forEach(rx=>{

            html += `
            <img
            src="<?= BASE_URL ?>/uploads/radiografias/${rx.arquivo}"
            style="width:60px;height:60px;object-fit:cover;border-radius:6px;margin:4px;cursor:pointer"
            onclick="window.open(this.src)"
            >
            `;

        });

        div.innerHTML = html;

    })

    .catch(err => {
        console.error("Erro RX:", err);
    });

}

// 🔥 UPLOAD RADIOGRAFIA (CORRIGIDO)

const btnUpload = document.getElementById("uploadRX");

if(btnUpload){

    btnUpload.addEventListener("click", function(){

        let arquivo = document.getElementById("arquivoRX")?.files[0];
        let dente = document.getElementById("denteSelecionado")?.value;

        if(!arquivo){
            alert("Selecione uma radiografia");
            return;
        }

        // 🔥 verificar dente
        if(!dente){
            if(!confirm("Nenhum dente selecionado.\n\nDeseja enviar como radiografia geral (panorâmica)?")){
                return;
            }
        }

        let formData = new FormData();

        formData.append("arquivo", arquivo);
        formData.append("paciente_id", "<?= $paciente['id'] ?>");
        formData.append("dente", dente);

        fetch("<?= BASE_URL ?>/radiografias/upload", {

            method: "POST",
            body: formData

        })
        .then(res => res.json())
        .then(resp => {

            if(resp.status === "ok"){
                location.reload();
            }else{
                alert("Erro ao enviar radiografia");
            }

        })
        .catch(err => {
            console.error("Erro upload RX:", err);
        });

    });

}



/* ================= EXCLUIR RADIOGRAFIA ================= */

function excluirRX(id){

if(!confirm("Deseja excluir esta radiografia?")) return;

fetch("<?= BASE_URL ?>/radiografias/excluir",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:"id="+id

})
.then(r=>r.json())
.then(resp=>{

if(resp.status==="ok"){
location.reload();
}else{
alert("Erro ao excluir radiografia");
}

});

}

/* ================= CARREGAR HISTÓRICO DO DENTE ================= */

function carregarHistoricoDente(dente){

    let paciente = document.getElementById("paciente_id")?.value;

    if(!paciente) return;

    fetch("<?= BASE_URL ?>/prontuarios/historicoDente",{

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body: JSON.stringify({
            paciente: paciente,
            dente: dente
        })

    })

    .then(res=>res.json())

    .then(data=>{

        let div = document.getElementById("historico_dente");

        if(!div) return;

        if(!data || data.length===0){

            div.innerHTML="Nenhum registro";
            return;

        }

        let html="";

        data.forEach(function(r){

            html+=`
            <div style="font-size:13px;margin-bottom:8px;padding-bottom:6px;border-left:3px solid #3b82f6;padding-left:6px">

            <strong>${r.procedimento}</strong>

            ${r.face ? " "+r.face : ""}

            <br>

            <span style="color:#64748b;font-size:12px">
            ${r.status}
            </span>

            </div>
            `;

        });

        div.innerHTML=html;

    });

}

let orcamento = [];

/* ================= CLIQUE GERAL ================= */

document.addEventListener("click", function(e){

    // 🔥 CLICK EM DENTE
    const tooth = e.target.closest(".tooth");
    if(tooth){

        const numero = tooth.dataset.dente;

        const input = document.getElementById("denteSelecionado");
        const visual = document.getElementById("denteVisual");

        if(input) input.value = numero;
        if(visual) visual.value = numero;

        document.querySelectorAll(".tooth").forEach(t => {
            t.style.outline = "";
        });

        tooth.style.outline = "2px solid #22c55e";

        console.log("Dente clicado:", numero);
        return;
    }

    // 🔥 CLICK PROCEDIMENTO GERAL
    const item = e.target.closest(".proc-geral");
    if(item){

        let nome = item.dataset.nome;
        let valor = parseFloat(item.dataset.valor || 0);

        const selectProc = document.getElementById("procedimentoSelect");
        const inputValor = document.getElementById("valorProcedimento");
        const denteInput = document.getElementById("denteSelecionado");
        const denteVisual = document.getElementById("denteVisual");

        if(denteInput) denteInput.value = "";
        if(denteVisual) denteVisual.value = "Procedimento geral";

        if(selectProc){
            for(let opt of selectProc.options){
                if(opt.text.trim() === nome.trim()){
                    opt.selected = true;
                    break;
                }
            }
        }

        if(inputValor){
            inputValor.value = valor.toFixed(2);
        }

        item.remove();
    }

});


/* ================= ATUALIZAR UI ================= */

function atualizarOrcamento() {

    const lista = document.getElementById("listaOrcamento");
    const totalEl = document.getElementById("totalOrcamento");

    if (!lista || !totalEl) {
        console.warn("Elementos do orçamento não encontrados");
        return;
    }

    let total = 0;

    if (!Array.isArray(orcamento) || orcamento.length === 0) {
        lista.innerHTML = "<em>Nenhum item</em>";
        totalEl.innerText = "0,00";
        return;
    }

    let html = "";

    orcamento.forEach((item, index) => {

        if (!item) return;

        const nome =
            item.nome ||
            item.procedimento_nome ||
            item.procedimento ||
            item.descricao ||
            "Procedimento";

        const valor = parseFloat(item.valor) || 0;
        const quantidade = parseInt(item.quantidade) || 1;

        const status = String(item.status || "planejado")
            .toLowerCase()
            .trim();

        console.log("STATUS ITEM:", status);

        const subtotal = valor * quantidade;

        // 🔥 Soma apenas se NÃO for existente
        if (status !== "existente") {
            total += subtotal;
        }

        html += `
            <div style="margin-bottom:6px;border-bottom:1px solid #eee;padding-bottom:4px;position:relative;">
                
                <strong>${nome}</strong><br>

                <small>
                    ${item.dente ? `Dente ${item.dente} - ` : ""}
                    Qtd: ${quantidade}
                    ${
                        status !== "existente"
                            ? ` - R$ ${subtotal.toFixed(2)}`
                            : ` - <span style="color:#9e9e9e;">(Existente)</span>`
                    }
                </small>

                <div style="position:absolute; right:0; top:0; display:flex; gap:4px;">
                    <button onclick="editarItem(${index})"
                        style="background:#f59e0b;color:white;border:none;border-radius:4px;font-size:11px;padding:3px 6px;cursor:pointer;">
                        ✏️
                    </button>

                    <button onclick="removerItem(${index})"
                        style="background:#ef4444;color:white;border:none;border-radius:4px;font-size:11px;padding:3px 6px;cursor:pointer;">
                        🗑️
                    </button>
                </div>

            </div>
        `;
    });

    // 🔥 Atualiza DOM uma única vez (melhor performance)
    lista.innerHTML = html;

    totalEl.innerText = total.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // 🔥 GARANTE que não quebre se a função não existir
    if (typeof atualizarPlanoTratamento === "function") {
        atualizarPlanoTratamento();
    }
}

/* ================= ATUALIZAR PLANO DE TRATAMENTO ================= */

function atualizarPlanoTratamento(){

    let campo = document.getElementById("textoPlano");
    if(!campo) return;

    if(!Array.isArray(orcamento) || orcamento.length === 0){
        campo.value = "";
        return;
    }

    let texto = "";

    orcamento.forEach(item => {

        let nome = item.nome || "Procedimento";
        let dente = item.dente ? " no dente " + item.dente : "";
        let status = String(item.status || "").toLowerCase().trim();

        // 🔥 NÃO INCLUI EXISTENTE
        if(status === "existente") return;

        texto += "- " + nome + dente + "\n";

    });

    campo.value = texto;
}


/* ================= REMOVER ITEM ================= */

function normalizarProcedimento(nome){

    nome = nome.toLowerCase().trim();

    // 🔥 REMOVE ACENTOS (ESSENCIAL)
    nome = nome.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    // 🔥 MAPA BASE
    const mapa = {
        "restauracao": "restauracao",
        "extracao": "extracao",
        "profilaxia": "profilaxia",
        "fluor": "fluor",
        "raspagem": "raspagem",
        "canal": "canal",
        "coroa": "coroa",
        "implante": "implante",
        "urgencia": "urgencia",
        "carie": "carie",
        "nucleo": "nucleo"
    };

    // 🔥 MATCH FLEXÍVEL (PEGA VARIAÇÕES)
    for(let chave in mapa){
        if(nome.includes(chave)){
            return mapa[chave];
        }
    }

    return nome;
}
  
 // ================= BOTÕES ORÇAMENTO =================

// 🔥 TODOS OS BOTÕES JUNTOS (ORGANIZADO)
const btnSalvarOrc = document.getElementById("salvarOrcamento");
const btnLimpar = document.getElementById("limparOrcamento");
const btnNovo = document.getElementById("novoOrcamento"); // ✅ NOVO BOTÃO

// ================= SALVAR =================
if(btnSalvarOrc){

    btnSalvarOrc.addEventListener("click", function(){

        let paciente = document.getElementById("paciente_id").value;

        if(orcamento.length === 0){
            alert("Nenhum item no orçamento");
            return;
        }

        fetch("<?= BASE_URL ?>/orcamentos/salvar", {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({
                paciente_id: paciente,
                itens: orcamento
            })

        })
        .then(r => r.json())
        .then(resp => {

            console.log("RESPOSTA JSON:", resp);

            if(resp.status === "ok"){
                alert("Orçamento salvo com sucesso!");
            }else{
                alert("Erro ao salvar: " + (resp.msg || ""));
            }

        })
        .catch(err => {
            console.error("ERRO:", err);
            alert("Erro na requisição");
        });

    });

}

// ================= NOVO ORÇAMENTO =================
if(btnNovo){

    btnNovo.addEventListener("click", function(){

        if(!confirm("Criar novo orçamento? O atual não será apagado do sistema.")) return;

        orcamento = [];
        atualizarOrcamento();

    });

}

// ================= LIMPAR (BANCO) =================
if(btnLimpar){

    btnLimpar.addEventListener("click", function(){

        if(!confirm("Deseja limpar o orçamento?")) return;

        let paciente = document.getElementById("paciente_id").value;

        fetch("<?= BASE_URL ?>/orcamentos/limpar/" + paciente)

        .then(r => r.json())
        .then(resp => {

            if(resp.status === "ok"){

                orcamento = [];
                atualizarOrcamento();

                alert("Orçamento removido");

            }else{
                alert("Erro ao limpar");
            }

        })
        .catch(err => {
            console.error(err);
            alert("Erro na requisição");
        });

    });

}



/*======================CARREGAR ORÇAMENTO EXISTENTE ================= */
function carregarOrcamento(){

    let paciente = document.getElementById("paciente_id")?.value;

    if(!paciente){
        console.warn("Paciente não encontrado");
        return;
    }

    fetch(BASE + "/orcamentos/ultimo/" + paciente)

    .then(r => r.json()) // 🔥 MUDA AQUI (IMPORTANTE)

    .then(lista => {

        console.log("STATUS VINDO DO BACK:", lista); // ✅ aqui funciona

        if(!Array.isArray(lista)){
            console.warn("Resposta inesperada:", lista);
            return;
        }

        orcamento = [];

        lista.forEach(item => {

    orcamento.push({
        nome: item.nome || item.procedimento_nome || item.descricao || "Procedimento",
        valor: item.valor,
        dente: item.dente,
        quantidade: item.quantidade || 1,
        status: item.status,
        tipo: item.dente ? "dente" : "geral"
    });

});

        atualizarOrcamento();

    })
    .catch(err => {
        console.error("Erro ao carregar orçamento:", err);
    });

}
/*============================================================== */
function getIconeProcedimento(nome){

    if(!nome) return null;

    let original = nome;

    nome = nome.toLowerCase().trim();

    // 🔥 REMOVE ACENTOS
    nome = nome.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    // ================= PRIORIDADE (ESPECÍFICOS) =================

    if(nome.includes("coroa sobre implante") || nome.includes("coroa_implante")){
        return "coroa_implante.png";
    }

    if(nome.includes("raiz residual") || nome.includes("raiz_residual")){
        return "raiz_residual.png";
    }

    // ================= ODONTOGRAMA =================

    if(nome.includes("cirurgia")){
        return "cirurgia.png"; // 🔥 CORREÇÃO PRINCIPAL
    }

    if(nome.includes("extracao") || nome.includes("exodontia") || nome.includes("remocao")){
        return "extracao.png";
    }

    if(nome.includes("canal") || nome.includes("endodont")){
        return "canal.png";
    }

    if(nome.includes("nucleo")){
        return "nucleo.png";
    }

    if(nome.includes("implante")){
        return "implante.png";
    }

    if(nome.includes("coroa")){
        return "coroa.png";
    }

    if(nome.includes("restauracao") || nome.includes("resina")){
        return "restauracao.png";
    }

    if(nome.includes("carie")){
        return "carie.png";
    }

    if(nome.includes("ausente")){
        return "ausente.png";
    }

    // ================= GERAIS =================

    if(nome.includes("profilaxia")) return "profilaxia.png";
    if(nome.includes("consulta")) return "consulta.png";
    if(nome.includes("condicionamento")) return "condicionamento.png";
    if(nome.includes("biofilme")) return "controle_biofilme.png";
    if(nome.includes("emergencia")) return "emergencia.png";
    if(nome.includes("periapical")) return "periapical.png";
    if(nome.includes("fluor")) return "fluor.png";
    if(nome.includes("fotografia")) return "fotografia.png";
    if(nome.includes("interproximal")) return "interproximal.png";
    if(nome.includes("manutencao")) return "manutencao_periodontal.png";
    if(nome.includes("modelo")) return "modelo_estudo.png";
    if(nome.includes("panoramica")) return "panoramica.png";
    if(nome.includes("placa")) return "placa_bruxismo.png";
    if(nome.includes("protese parcial")) return "protese_parcial.png";
    if(nome.includes("protese total")) return "protese_total.png";
    if(nome.includes("protocolo")) return "protocolo_implante.png";
    if(nome.includes("raspagem")) return "raspagem.png";
    if(nome.includes("selante")) return "selante.png";
    if(nome.includes("urgencia")) return "urgencia.png";
    if(nome.includes("atm")) return "atm.png";
    if(nome.includes("clareamento")) return "clareamento.png";
    if(nome.includes("enceramento")) return "enceramento.png";
    if(nome.includes("frenectomia labial")) return "frenectomia_labial.png";
    if(nome.includes("frenectomia lingual")) return "frenectomia_lingual.png";
    if(nome.includes("gengivectomia")) return "gengivectomia.png";
    if(nome.includes("oclusal")) return "oclusal.png";
    if(nome.includes("overdenture")) return "overdenture.png";
    if(nome.includes("raspagem sub")) return "raspagem_subgengival.png";
    if(nome.includes("raspagem supra")) return "raspagem_supragengival.png";
    if(nome.includes("reembazamento")) return "reembazamento.png";
    if(nome.includes("ulectomia")) return "ulectomia.png";

    console.warn("❌ Ícone não encontrado para:", original);

    return null;
}
// ============================================================

function editarItem(index){

    if(!modoEdicao){
        alert("Clique em 'Editar Orçamento' primeiro");
        return;
    }

    let item = orcamento[index];

    // 🔹 EDITAR PROCEDIMENTO
    let novoNome = prompt("Procedimento:", item.nome);
    if(novoNome === null) return;

    // 🔹 EDITAR VALOR
    let novoValor = prompt("Valor:", item.valor);
    if(novoValor === null) return;

    // 🔹 EDITAR DENTE
    let novoDente = prompt("Dente:", item.dente || "");
    if(novoDente === null) return;

    // 🔹 EDITAR OBSERVAÇÃO (se quiser usar)
    let novaObs = prompt("Observação:", item.observacao || "");
    if(novaObs === null) return;

    // 🔥 ATUALIZA OBJETO
    item.nome = novoNome;
    item.valor = parseFloat(novoValor);
    item.dente = novoDente;
    item.observacao = novaObs;

    atualizarOrcamento();
    salvarOrcamentoAuto(); // 🔥 AQUI

}

// ===============================================================
function removerItem(index){

    if(!confirm("Remover este item?")) return;

    orcamento.splice(index,1);

    atualizarOrcamento();

}

// 🔥 INICIALIZAÇÃO DO SISTEMA (ESSENCIAL)
document.addEventListener("DOMContentLoaded", function(){

    console.log("Sistema iniciado");

    // 🔥 GERA ODONTOGRAMA
    if(typeof gerarOdontograma === "function"){
        gerarOdontograma(mapaPermanente);
    } else {
        console.warn("Função gerarOdontograma não encontrada");
    }

    // 🔥 AGUARDA RENDERIZAÇÃO DO ODONTOGRAMA
    setTimeout(function(){

        let pacienteId = null;

        // 🔥 VALIDA FUNÇÃO
        if(typeof getPacienteId === "function"){
            pacienteId = getPacienteId();
        }

        if(!pacienteId){
            console.warn("Paciente não encontrado");
            return;
        }

        // 🔥 CARREGA PROCEDIMENTOS
        if(typeof carregarProcedimentos === "function"){
            carregarProcedimentos();
        }

        // 🔥 HISTÓRICO
        if(typeof carregarHistoricoPaciente === "function"){
            carregarHistoricoPaciente();
        }

        // 🔥 ORÇAMENTO
        if(typeof carregarOrcamento === "function"){
            carregarOrcamento();
        }

        // 🔥 PLANO
        if(typeof carregarPlano === "function"){
            carregarPlano();
        }

        // 🔥 EVOLUÇÃO
        if(typeof carregarEvolucao === "function"){
            carregarEvolucao();
        }

    }, 200);

});

// 🔥 ATUALIZA VALOR AUTOMATICAMENTE (SEMPRE FUNCIONA)
window.addEventListener("load", function(){

    const selectProc = document.getElementById("procedimentoSelect");
    const inputValor = document.getElementById("valorProcedimento");

    if(selectProc){

        selectProc.addEventListener("change", function(){

            let option = this.selectedOptions[0];
            if(!option) return;

            let valor = parseFloat(option.dataset.valor || 0);

            inputValor.value = valor.toFixed(2);

        });

    }

});

// 🔥 GARANTE CLIQUE NOS DENTES (INDEPENDENTE DE ERROS)


// 🔥 ADICIONAR PROCEDIMENTO GERAL NA TELA
function adicionarProcedimentoGeral(nome, valor){

    const area = document.getElementById("areaProcedimentosGerais");
    if(!area) return;

    // 🔥 EVITA DUPLICAR NA TELA
    let existente = Array.from(area.querySelectorAll(".proc-geral-item"))
        .find(el => el.dataset.nome === nome);

    if(existente) return;

    const div = document.createElement("div");

    div.className = "proc-geral-item";
    div.dataset.nome = nome;

    div.style.display = "flex";
    div.style.alignItems = "center";
    div.style.gap = "6px";
    div.style.padding = "6px 10px";
    div.style.borderRadius = "8px";
    div.style.background = "#f1f5f9";
    div.style.fontSize = "12px";

    let icone = getIconeProcedimento(nome) || "default.png";

    div.innerHTML = `
        <img src="<?= BASE_URL ?>/assets/img/procedimentos/gerais/${icone}" style="width:20px;height:20px;">
        <span>${nome}</span>
    `;

    area.appendChild(div);
}

/*==============CARREGAR PLANO DE TRATAMENTO ==============*/

function carregarPlano(){

    let paciente = document.getElementById("paciente_id").value;

    fetch("<?= BASE_URL ?>/prontuarios/buscarPlano/" + paciente)
    .then(r => r.json())
    .then(data => {

        if(data && data.descricao){
            document.getElementById("textoPlano").value = data.descricao;
        }

    });
}

/*================= CARREGAR EVOLUÇÃO CLÍNICA ================= */
function carregarEvolucao(){

    let pacienteEl = document.getElementById("paciente_id");
    if(!pacienteEl) return;

    let paciente = pacienteEl.value;

    fetch("<?= BASE_URL ?>/prontuarios/buscarEvolucao/" + paciente)
    .then(r => r.json())
    .then(lista => {

        let div = document.getElementById("timelineEvolucao");
        if(!div) return;

        if(!lista || lista.length === 0){
            div.innerHTML = "<span class='text-muted small'>Sem evolução registrada</span>";
            return;
        }

        let html = "";

        lista.forEach(e => {

            html += `
                <div style="
                    background:#f8fafc;
                    padding:6px;
                    border-radius:6px;
                    margin-bottom:6px;
                    font-size:12px;
                    border-left:3px solid #3b82f6;
                ">
                    <strong>${formatarData(e.data)}</strong><br>
                    ${e.descricao || ""}
                </div>
            `;
        });

        div.innerHTML = html;

    });
}
/*==========================Formatar data para exibição ==================*/

    function formatarData(data){

    if(!data) return "";

    let d = new Date(data);

    return d.toLocaleDateString("pt-BR") + " " +
           d.toLocaleTimeString("pt-BR", {
               hour:'2-digit',
               minute:'2-digit'
           });
}

// ... suas outras funções (carregarPlano, carregarEvolucao, etc)

// 🔥 FUNÇÃO DO PDF (COLOQUE NO FINAL)
function gerarPDFPlano(){

    let area = document.getElementById("areaPDF");

    if(!area){
        alert("Área PDF não encontrada");
        return;
    }

    // 🔥 MOSTRA TEMPORARIAMENTE
    area.style.display = "block";

    // 🔥 DADOS
    document.getElementById("pdfPaciente").innerText =
        document.getElementById("nomePaciente")?.innerText || "";

    document.getElementById("pdfData").innerText =
        new Date().toLocaleDateString("pt-BR");

    // 🔥 PLANO (ORÇAMENTO)
    let htmlPlano = "";
    let total = 0;

    orcamento.forEach(item => {

        if(!item) return;

        let status = String(item.status || "").toLowerCase().trim();
        if(status === "existente") return;

        let valor = parseFloat(item.valor) || 0;
        let qtd = parseInt(item.quantidade) || 1;
        let subtotal = valor * qtd;

        total += subtotal;

        let nome =
            item.nome ||
            item.procedimento_nome ||
            item.procedimento ||
            item.descricao ||
            "Procedimento";

        htmlPlano += `
            <div style="display:flex; justify-content:space-between;">
                <span>${nome}</span>
                <span>R$ ${subtotal.toFixed(2)}</span>
            </div>
        `;
    });

    htmlPlano += `<strong>Total: R$ ${total.toFixed(2)}</strong>`;

    document.getElementById("pdfPlano").innerHTML = htmlPlano;

    // 🔥 ODONTOGRAMA
    let odonto = document.getElementById("odontograma");

    html2canvas(odonto, { scale: 2 }).then(canvas => {

        document.getElementById("pdfOdontograma").innerHTML =
            `<img src="${canvas.toDataURL()}" style="width:100%;">`;

        gerarPDFfinal(area);
    });
}

function gerarPDFProntuario(){

    let area = document.getElementById("areaPDF");

    if(!area){
        alert("Área PDF não encontrada");
        return;
    }

    area.style.display = "block";

    // 🔥 PACIENTE
    document.getElementById("pdfPaciente").innerText =
        document.getElementById("nomePaciente")?.innerText || "";

    document.getElementById("pdfData").innerText =
        new Date().toLocaleDateString("pt-BR");

    // 🔥 PLANO TEXTO
    document.getElementById("pdfPlano").innerHTML =
        `<div style="white-space:pre-line;">${
            document.getElementById("textoPlano")?.value || ""
        }</div>`;

    // 🔥 ODONTOGRAMA
    let odonto = document.getElementById("odontograma");

    html2canvas(odonto, { scale: 2 }).then(canvas => {

        document.getElementById("pdfOdontograma").innerHTML =
            `<img src="${canvas.toDataURL()}" style="width:100%;">`;

        gerarPDFfinal(area);
    });
}

function gerarPDFfinal(area){

    let opt = {
        margin: 10,
        filename: 'documento.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf()
        .set(opt)
        .from(area)
        .save()
        .then(() => {
            area.style.display = "none"; // 🔥 ESCONDE DE NOVO
        })
        .catch(err => {
            console.error("Erro PDF:", err);
            area.style.display = "none";
        });
}

window.aprovarOrcamento = function(){

    console.log("CLIQUE OK");

    let paciente = document.getElementById("paciente_id")?.value;

    if(!paciente){
        alert("Paciente não encontrado");
        return;
    }

    if(!confirm("Deseja aprovar o orçamento?")) return;

    fetch(BASE + "/orcamentos/aprovar", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            paciente_id: paciente
        })
    })
    .then(r => r.json())
    .then(res => {

        console.log("RESPOSTA:", res);

        if(res.status === "ok"){

            alert("Orçamento aprovado!");

            carregarOrcamento?.();
            carregarProcedimentos?.();
            carregarHistoricoPaciente?.();

        } else {
            alert("Erro: " + (res.msg || ""));
        }

    })
    .catch(err => {
        console.error(err);
        alert("Erro na requisição");
    });

};


// 🔥 SALVAR PLANO
let btnSalvarPlano = document.getElementById("salvarPlano");

if(btnSalvarPlano){
    btnSalvarPlano.addEventListener("click", function(){

        let paciente = document.getElementById("paciente_id")?.value;
        let texto = document.getElementById("textoPlano")?.value;

        fetch(BASE + "/prontuarios/salvarPlano", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                paciente_id: paciente,
                descricao: texto
            })
        })
        .then(r => r.text())
        .then(resp => {
            console.log("RESPOSTA BACK:", resp);
            alert("Plano salvo!");
        })
        .catch(err => {
            console.error(err);
        });

    });
}


function gerarPDFPlano(){

    let paciente_id = document.getElementById("paciente_id").value;

    if(!paciente_id){
        alert("Paciente não encontrado");
        return;
    }

    // 🔥 pega a base da URL automaticamente
    let base = window.location.origin + "/odonto/public";

    window.open(base + "/prontuarios/pdfPlano/" + paciente_id, "_blank");
}

function gerarPDFProntuario(){

    let paciente_id = document.getElementById("paciente_id").value;

    let base = window.location.origin + "/odonto/public";

    window.open(base + "/prontuarios/pdfProntuario/" + paciente_id, "_blank");
}



</script>