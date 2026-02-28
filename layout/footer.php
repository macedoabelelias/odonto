<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    </div> <!-- content -->
</div> <!-- main -->
</div> <!-- wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
$(document).ready(function(){

    // DataTables
    $('#tabelaPacientes').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
        }
    });

    // Máscaras
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 00000-0000');
    $('#cep').mask('00000-000');

    // CEP automático
    $('#cep').blur(function(){

        var cep = $(this).val().replace(/\D/g, '');

        if(cep != ''){

            $.getJSON('https://viacep.com.br/ws/'+ cep +'/json/', function(dados){

                if(!("erro" in dados)){
                    $('#endereco').val(dados.logradouro);
                    $('#bairro').val(dados.bairro);
                    $('#cidade').val(dados.localidade);
                    $('#estado').val(dados.uf);
                }

            });

        }

    });

    // Idade automática
    $('#data_nascimento').change(function(){

        var nascimento = new Date($(this).val());
        var hoje = new Date();

        var idade = hoje.getFullYear() - nascimento.getFullYear();
        var m = hoje.getMonth() - nascimento.getMonth();

        if (m < 0 || (m === 0 && hoje.getDate() < nascimento.getDate())) {
            idade--;
        }

        $('#idade').val(idade + " anos");
    });

});

// EDITAR PACIENTE
$(document).on('click', '.btn-editar', function(){

    $('#tituloModal').text('Editar Paciente');

    $('#paciente_id').val($(this).data('id'));
    $('input[name="nome"]').val($(this).data('nome'));
    $('#cpf').val($(this).data('cpf'));
    $('#data_nascimento').val($(this).data('data'));
    $('#telefone').val($(this).data('telefone'));
    $('input[name="email"]').val($(this).data('email'));
    $('#cep').val($(this).data('cep'));
    $('#endereco').val($(this).data('endereco'));
    $('#bairro').val($(this).data('bairro'));
    $('#cidade').val($(this).data('cidade'));
    $('#estado').val($(this).data('estado'));
    $('textarea[name="observacoes"]').val($(this).data('observacoes'));

    // calcular idade
    var nascimento = new Date($(this).data('data'));
    var hoje = new Date();
    var idade = hoje.getFullYear() - nascimento.getFullYear();
    $('#idade').val(idade + " anos");

    $('#modalPaciente').modal('show');
});
</script>



</body>
</html>