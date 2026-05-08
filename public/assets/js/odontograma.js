document.addEventListener("DOMContentLoaded", function(){

const container = document.getElementById("odontograma");

if(!container) return;

/* =========================
DENTES PERMANENTES
========================= */

const dentes = [
18,17,16,15,14,13,12,11,
21,22,23,24,25,26,27,28,
48,47,46,45,44,43,42,41,
31,32,33,34,35,36,37,38
];

/* =========================
CRIAR DENTES
========================= */

dentes.forEach(function(numero){

    let dente = document.createElement("div");
    dente.classList.add("dente");
    dente.dataset.dente = numero;

    /* coroa */
    let coroa = document.createElement("div");
    coroa.classList.add("coroa");

    /* raiz */
    let raiz = document.createElement("div");
    raiz.classList.add("raiz");

    /* camada de procedimentos */
    let marcacoes = document.createElement("div");
    marcacoes.classList.add("marcacoes");

    /* montar estrutura */
    dente.appendChild(coroa);
    dente.appendChild(raiz);
    dente.appendChild(marcacoes);

    container.appendChild(dente);

    /* =========================
    CLICK DO DENTE
    ========================= */

    dente.addEventListener("click", function(){

        let numeroDente = this.dataset.dente;

        let campoDente = document.getElementById("denteSelecionado");
        let campoVisual = document.getElementById("denteVisual");

        if(campoDente) campoDente.value = numeroDente;
        if(campoVisual) campoVisual.value = numeroDente;

        document.querySelectorAll(".dente").forEach(function(d){
            d.classList.remove("ativo");
        });

        this.classList.add("ativo");

    });

    /* =========================
    TOOLTIP
    ========================= */

    dente.addEventListener("mouseover", function(e){
        mostrarTooltipDente(numero, e);
    });

    dente.addEventListener("mouseout", function(){
        let tooltip = document.getElementById("tooltipDente");
        if(tooltip){
            tooltip.style.display = "none";
        }
    });

});

/* =========================
FUNÇÃO TOOLTIP
========================= */

function mostrarTooltipDente(dente, e){

    let paciente = document.getElementById("paciente_id")?.value;

    if(!paciente) return;

    fetch("/odonto/public/prontuarios/historicoDente",{
        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },
        body: JSON.stringify({
            paciente: paciente,
            dente: dente
        })
    })

    .then(res => res.json())
    .then(data => {

        let tooltip = document.getElementById("tooltipDente");
        if(!tooltip) return;

        let html = "<strong>Dente "+dente+"</strong><br>";

        if(data.length === 0){
            html += "Sem registros";
        } else {

            data.forEach(function(r){
                html += r.procedimento;

                if(r.face){
                    html += " " + r.face;
                }

                html += " (" + r.status + ")<br>";
            });

        }

        tooltip.innerHTML = html;

        tooltip.style.top = (e.pageY - 150) + 'px';
        tooltip.style.left = (e.pageX - 50) + 'px';
        tooltip.style.display = "block";

    });

}

/* =========================
RENDERIZAR PROCEDIMENTOS
========================= */

function renderizarProcedimentos(procedimentos){

    procedimentos.forEach(function(proc){

        let icone = proc.icone;

        if(!icone) return;

        // 🔥 trocar por status
        if(proc.status === 'realizado'){
            icone = icone.replace('.png', '_realizado.png');
        } else {
            icone = icone.replace('.png', '_a_realizar.png');
        }

        let caminho = "/odonto/public/assets/img/odontograma/" + icone;

        let dente = document.querySelector(`[data-dente="${proc.dente}"]`);
        if(!dente) return;

        let marcacoes = dente.querySelector(".marcacoes");
        if(!marcacoes) return;

        let img = document.createElement("img");
        img.src = caminho;
        img.classList.add("icone-procedimento");

        // 📍 posição
        if(proc.local === 'coroa'){
            img.classList.add("icone-coroa");
        }
        else if(proc.local === 'raiz'){
            img.classList.add("icone-raiz");
        }
        else{
            img.classList.add("icone-centro");
        }

        img.style.left = "50%";

        marcacoes.appendChild(img);

    });

}

/* =========================
CHAMAR RENDERIZAÇÃO
========================= */

if(typeof procedimentos !== "undefined"){
    renderizarProcedimentos(procedimentos);
}

});