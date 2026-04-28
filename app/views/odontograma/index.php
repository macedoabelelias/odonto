<h3 class="mb-4">🦷 Odontograma</h3>

<!-- seus cards que já existem -->
<div class="card">
    Conteúdo que você já tinha
</div>

<div class="card">
    Outro conteúdo que você já tinha
</div>

<!-- NOVO ODONTOGRAMA -->
<div class="card">
    <div class="card-title">
        Odontograma
    </div>

    <div id="odontograma" class="odontograma"></div>
</div>

<!-- TOOLTIP DO DENTE -->
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

<!-- 🔥 JS GLOBAL -->
<script>
document.addEventListener("DOMContentLoaded", function(){

    const select = document.getElementById("procedimentoSelect");
    const inputValor = document.getElementById("valorProcedimento");

    // só roda se existir (painel lateral)
    if(select && inputValor){
        select.addEventListener("change", function(){

            let valor = this.options[this.selectedIndex].dataset.valor || 0;

            inputValor.value = valor;

        });
    }

});
</script>

<script src="/odonto/public/assets/js/odontograma.js"></script>