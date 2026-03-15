document.addEventListener("DOMContentLoaded", function(){

const container = document.getElementById("odontograma");

if(!container) return;

/* dentes permanentes */

const dentes = [
18,17,16,15,14,13,12,11,
21,22,23,24,25,26,27,28,
48,47,46,45,44,43,42,41,
31,32,33,34,35,36,37,38
];

/* gerar dentes */

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

dente.appendChild(coroa);
dente.appendChild(raiz);
dente.appendChild(marcacoes);

container.appendChild(dente);

});

});
