</div> <!-- page-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

/* =====================================
   MENU CONFIGURAÇÕES
===================================== */

const btn = document.getElementById("btnConfig");
const menu = document.getElementById("menuConfig");

if(btn && menu){

btn.addEventListener("click", function(e){
e.stopPropagation();
menu.style.display = (menu.style.display === "flex") ? "none" : "flex";
});

document.addEventListener("click", function(){
menu.style.display = "none";
});

}


/* =====================================
   MÁSCARA CPF
===================================== */

function mascaraCPF(campo){

campo.addEventListener("input",function(){

let v = campo.value.replace(/\D/g,'')

v = v.substring(0,11)

v = v.replace(/(\d{3})(\d)/,"$1.$2")
v = v.replace(/(\d{3})(\d)/,"$1.$2")
v = v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")

campo.value = v

})

}


/* =====================================
   VALIDAR CPF
===================================== */

function validarCPF(cpf){

cpf = cpf.replace(/[^\d]+/g,'')

if(cpf.length !== 11) return false

if(
cpf === "00000000000" ||
cpf === "11111111111" ||
cpf === "22222222222" ||
cpf === "33333333333" ||
cpf === "44444444444" ||
cpf === "55555555555" ||
cpf === "66666666666" ||
cpf === "77777777777" ||
cpf === "88888888888" ||
cpf === "99999999999"
) return false

let soma = 0
let resto

for(let i=1;i<=9;i++)
soma += parseInt(cpf.substring(i-1,i))*(11-i)

resto = (soma*10)%11

if(resto === 10 || resto === 11)
resto = 0

if(resto !== parseInt(cpf.substring(9,10)))
return false

soma = 0

for(let i=1;i<=10;i++)
soma += parseInt(cpf.substring(i-1,i))*(12-i)

resto = (soma*10)%11

if(resto === 10 || resto === 11)
resto = 0

if(resto !== parseInt(cpf.substring(10,11)))
return false

return true

}


/* =====================================
   MÁSCARA TELEFONE
===================================== */

function mascaraTelefone(campo){

campo.addEventListener("input",function(){

let v = campo.value.replace(/\D/g,'')

v = v.substring(0,11)

if(v.length > 10){

v = v.replace(/^(\d{2})(\d)/,"($1) $2")
v = v.replace(/(\d{5})(\d{4})$/,"$1-$2")

}else if(v.length > 5){

v = v.replace(/^(\d{2})(\d)/,"($1) $2")
v = v.replace(/(\d{4})(\d{4})$/,"$1-$2")

}

campo.value = v

})

}


/* =====================================
   MÁSCARA CEP
===================================== */

function mascaraCEP(campo){

campo.addEventListener("input",function(){

let v = campo.value.replace(/\D/g,'')

v = v.substring(0,8)

v = v.replace(/(\d{5})(\d)/,"$1-$2")

campo.value = v

})

}


/* =====================================
   BUSCAR CEP AUTOMÁTICO
===================================== */

function buscarCEP(){

const campoCEP = document.querySelector('input[name="cep"]')

if(!campoCEP) return

campoCEP.addEventListener("blur",function(){

let cep = this.value.replace(/\D/g,'')

if(cep.length !== 8) return

fetch("https://viacep.com.br/ws/"+cep+"/json/")
.then(res => res.json())
.then(dados => {

if(dados.erro) return

const endereco = document.querySelector('input[name="endereco"]')
const bairro = document.querySelector('input[name="bairro"]')
const cidade = document.querySelector('input[name="cidade"]')
const estado = document.querySelector('input[name="estado"]')

if(endereco) endereco.value = dados.logradouro
if(bairro) bairro.value = dados.bairro
if(cidade) cidade.value = dados.localidade
if(estado) estado.value = dados.uf

})

})

}


/* =====================================
   CALCULAR IDADE
===================================== */

function calcularIdade(){

const campoData = document.querySelector('input[name="data_nascimento"]')
const campoIdade = document.querySelector('#idade')

if(!campoData || !campoIdade) return

campoData.addEventListener("change",function(){

const nasc = new Date(this.value)
const hoje = new Date()

let idade = hoje.getFullYear() - nasc.getFullYear()

const m = hoje.getMonth() - nasc.getMonth()

if(m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())){
idade--
}

campoIdade.value = idade + " anos"

})

}


/* =====================================
   ATIVAR MÁSCARAS
===================================== */

document.querySelectorAll('input[name="cpf"], input[name="responsavel_cpf"]').forEach(function(campo){

mascaraCPF(campo)

campo.addEventListener("blur",function(){

let cpf = campo.value

if(cpf === "") return

if(!validarCPF(cpf)){

alert("CPF inválido")

campo.focus()
campo.value = ""

}

})

})

document.querySelectorAll('input[name="telefone"], input[name="whatsapp"], input[name="responsavel_telefone"]').forEach(mascaraTelefone)

document.querySelectorAll('input[name="cep"]').forEach(mascaraCEP)


/* ATIVAR FUNÇÕES */

calcularIdade()
buscarCEP()

});

</script>

</body>
</html>