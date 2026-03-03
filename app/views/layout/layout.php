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

<script>
$(document).ready(function(){

    // CPF
    $('input[name="cpf"]').mask('000.000.000-00');

    // Telefone fixo
    $('input[name="telefone"]').mask('(00) 0000-0000');

    // WhatsApp / celular
    $('input[name="whatsapp"]').mask('(00) 00000-0000');

    // CEP
    $('input[name="cep"]').mask('00000-000');

    // RESPONSÁVEL CPF
    $('input[name="responsavel_cpf"]').mask('000.000.000-00');

    // RESPONSÁVEL TELEFONE
    $('input[name="responsavel_telefone"]').mask('(00) 00000-0000');


    // ==========================
    // BUSCAR CEP AUTOMÁTICO
    // ==========================
    $('input[name="cep"]').blur(function(){

        var cep = $(this).val().replace(/\D/g, '');

        if(cep.length === 8){

            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/", function(dados){

                if(!dados.erro){
                    $('input[name="endereco"]').val(dados.logradouro);
                    $('input[name="bairro"]').val(dados.bairro);
                    $('input[name="cidade"]').val(dados.localidade);
                    $('input[name="estado"]').val(dados.uf);
                }

            });

        }

    });

});
</script>

</body>
</html>