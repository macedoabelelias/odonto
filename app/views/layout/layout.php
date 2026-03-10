<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel - Odonto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>

<div class="d-flex">

    <?php require BASE_PATH . "/app/views/layout/sidebar.php"; ?>

    <div class="flex-grow-1" style="margin-left:240px;">

    <?php require BASE_PATH . "/app/views/layout/navbar.php"; ?>

    <div class="container-fluid mt-4">
        <?php require $viewFile; ?>
    </div>

</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<<script>

$(document).ready(function(){

/* TELEFONE */

$('#telefone').mask('(00) 00000-0000');


/* CEP */

$('#cep').mask('00000-000');


/* CPF OU CNPJ */

$('#cpf_cnpj').on('input', function(){

let valor = $(this).val().replace(/\D/g,'');

if(valor.length <= 11){

$(this).mask('000.000.000-00');

}else{

$(this).mask('00.000.000/0000-00');

}

});


/* CEP AUTOMÁTICO */

$("#cep").blur(function(){

let cep = $(this).val().replace(/\D/g,'');

if(cep.length != 8){
return;
}

let url = "https://viacep.com.br/ws/"+cep+"/json/";

$.getJSON(url,function(dados){

if(!("erro" in dados)){

$("#endereco").val(dados.logradouro);
$("#bairro").val(dados.bairro);
$("#cidade").val(dados.localidade);
$("#estado").val(dados.uf);

}

});

});

});

</script>

</body>
</html>