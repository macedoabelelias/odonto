<h4 class="mb-3">
    Prontuário de <?= htmlspecialchars($paciente['nome']) ?>
</h4>

<hr>

<!-- ========================= -->
<!-- OBSERVAÇÕES CLÍNICAS -->
<!-- ========================= -->

<form method="POST" action="<?= BASE_URL ?>/prontuarios/salvar">

    <input type="hidden" name="paciente_id" value="<?= $paciente['id'] ?>">

    <div class="mb-3">
        <label><strong>Observações Clínicas</strong></label>
        <textarea name="observacoes" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">
        Adicionar Registro
    </button>

</form>

<hr>

<!-- ========================= -->
<!-- ODONTOGRAMA DECÍDUO -->
<!-- ========================= -->

<h5>Odontograma – Dentes Decíduos</h5>

<style>
.face {
    fill: white;
    stroke: #333;
    cursor: pointer;
    transition: 0.2s;
}

.face:hover {
    fill: #b3e5fc;
}

.tooth-number {
    font-size: 10px;
    text-anchor: middle;
}
</style>

<svg width="1000" height="300">

<?php

$arcadaSuperior = [55,54,53,52,51,61,62,63,64,65];
$arcadaInferior = [85,84,83,82,81,71,72,73,74,75];

function desenharDente($numero, $x, $y) {

    $size = 20;

    echo "
    <!-- Dente $numero -->

    <!-- Vestibular -->
    <rect x='".($x+$size)."'
          y='$y'
          width='$size'
          height='$size'
          class='face'
          data-dente='$numero'
          data-face='V' />

    <!-- Mesial -->
    <rect x='$x'
          y='".($y+$size)."'
          width='$size'
          height='$size'
          class='face'
          data-dente='$numero'
          data-face='M' />

    <!-- Oclusal -->
    <rect x='".($x+$size)."'
          y='".($y+$size)."'
          width='$size'
          height='$size'
          class='face'
          data-dente='$numero'
          data-face='O' />

    <!-- Distal -->
    <rect x='".($x+($size*2))."'
          y='".($y+$size)."'
          width='$size'
          height='$size'
          class='face'
          data-dente='$numero'
          data-face='D' />

    <!-- Lingual -->
    <rect x='".($x+$size)."'
          y='".($y+($size*2))."'
          width='$size'
          height='$size'
          class='face'
          data-dente='$numero'
          data-face='L' />

    <text x='".($x+$size*1.5)."'
          y='".($y-5)."'
          class='tooth-number'>$numero</text>
    ";
}

// Desenha arcada superior
$x = 50;
foreach($arcadaSuperior as $d){
    desenharDente($d, $x, 50);
    $x += 80;
}

// Desenha arcada inferior
$x = 50;
foreach($arcadaInferior as $d){
    desenharDente($d, $x, 180);
    $x += 80;
}

?>

</svg>

<hr>

<!-- ========================= -->
<!-- HISTÓRICO TEXTUAL -->
<!-- ========================= -->

<h5>Histórico Clínico</h5>

<?php if(!empty($prontuarios)): ?>
    <?php foreach($prontuarios as $p): ?>
        <div class="card mb-2">
            <div class="card-body">
                <small>
                    <?= date('d/m/Y H:i', strtotime($p['created_at'])) ?>
                </small>
                <p><?= nl2br(htmlspecialchars($p['observacoes'])) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nenhum registro encontrado.</p>
<?php endif; ?>



<!-- ========================= -->
<!-- SCRIPT SALVAR FACE -->
<!-- ========================= -->

<script>
document.querySelectorAll('.face').forEach(face => {
    face.addEventListener('click', function() {

        const dente = this.dataset.dente;
        const faceSelecionada = this.dataset.face;

        let status = prompt("Status: Cárie, Restauração, Extraído...");

        if(status){

            fetch("<?= BASE_URL ?>/odontograma/salvar", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    paciente_id: <?= $paciente['id'] ?>,
                    dente: dente,
                    face: faceSelecionada,
                    status: status
                })
            })
            .then(res => res.text())
            .then(() => {
                face.style.fill = "#ef5350";
                alert("Registro salvo!");
            });

        }
    });
});
</script>