<?php

require_once BASE_PATH . "/app/models/OrientacaoPaciente.php";
require_once BASE_PATH . "/app/models/Paciente.php";

class OrientacoesController extends Controller {

public function salvar()
{

    $paciente_id = $_POST['paciente_id'] ?? null;

    $titulo = $_POST['titulo'] ?? '';

    $texto = $_POST['texto'] ?? '';

    $imagem = null;

    // =====================================
    // 🔥 PASTA UPLOAD
    // =====================================

    $dir =
        BASE_PATH .
        "/public/uploads/orientacoes/";

    if(!is_dir($dir)){

        mkdir($dir, 0777, true);

    }

    // =====================================
    // 🔥 IMAGEM PRINCIPAL
    // =====================================

    if(

        isset($_FILES['imagem']) &&

        !empty($_FILES['imagem']['name'])

    ){

        $nome =

            time() . "_" .

            preg_replace(
                '/[^a-zA-Z0-9\._-]/',
                '_',
                basename($_FILES['imagem']['name'])
            );

        move_uploaded_file(

            $_FILES['imagem']['tmp_name'],

            $dir . $nome

        );

        $imagem = $nome;

    }

    // =====================================
    // 🔥 MODEL
    // =====================================

    $model = new OrientacaoPaciente();

    // 🔥 SALVA ORIENTAÇÃO
    $orientacao_id = $model->salvar([

        'paciente_id' => $paciente_id,

        'titulo' => $titulo,

        'texto' => $texto,

        'imagem' => $imagem

    ]);

    // =====================================
    // 🔥 ANEXOS CLÍNICOS
    // =====================================

    if(

        isset($_FILES['anexos']) &&

        !empty($_FILES['anexos']['name'][0])

    ){

        foreach(

            $_FILES['anexos']['tmp_name']

            as $i => $tmp

        ){

            if(empty($tmp)) continue;

            $nomeArquivo =

                time() . "_" .

                preg_replace(
                    '/[^a-zA-Z0-9\._-]/',
                    '_',
                    basename(
                        $_FILES['anexos']['name'][$i]
                    )
                );

            move_uploaded_file(

                $tmp,

                $dir . $nomeArquivo

            );

            // 🔥 SALVA NO BANCO
            $model->salvarArquivo([

                'orientacao_id' =>
                    $orientacao_id,

                'arquivo' =>
                    $nomeArquivo

            ]);

        }

    }

    header(

        "Location: " .

        $_SERVER['HTTP_REFERER']

    );

    exit;

}

public function pdf()
{

    $paciente_id = $_GET['paciente_id'] ?? null;

    if(!$paciente_id){

        die("Paciente não encontrado");

    }

    require_once BASE_PATH . "/app/models/Paciente.php";

    $pacienteModel = new Paciente();

    $paciente =
        $pacienteModel->buscarPorId($paciente_id);

    // 🔥 ORIENTAÇÃO
    $orientacaoModel = new OrientacaoPaciente();

    $orientacao =
        $orientacaoModel->buscarUltima($paciente_id);

    // 🔥 ANEXOS
    $arquivos = [];

    if(!empty($orientacao['id'])){

        $arquivos =

            $orientacaoModel->listarArquivos(
                $orientacao['id']
            );

    }

    require BASE_PATH . "/app/views/orientacoes/pdf.php";

}

}