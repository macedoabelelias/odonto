<?php

require_once BASE_PATH . "/app/models/OrientacaoPaciente.php";

class OrientacoesController extends Controller {

    public function salvar()
    {

        $paciente_id = $_POST['paciente_id'] ?? null;
        $titulo = $_POST['titulo'] ?? '';
        $texto = $_POST['texto'] ?? '';

        $imagem = null;

        // =========================
        // UPLOAD
        // =========================

        if(isset($_FILES['imagem']) && !empty($_FILES['imagem']['name'])){

            $dir = BASE_PATH . "/public/uploads/orientacoes/";

            if(!is_dir($dir)){
                mkdir($dir, 0777, true);
            }

            $nome = time() . '_' . basename($_FILES['imagem']['name']);

            move_uploaded_file(
                $_FILES['imagem']['tmp_name'],
                $dir . $nome
            );

            $imagem = $nome;

        }

        $model = new OrientacaoPaciente();

        $model->salvar([

            'paciente_id' => $paciente_id,
            'titulo' => $titulo,
            'texto' => $texto,
            'imagem' => $imagem

        ]);

        header("Location: " . $_SERVER['HTTP_REFERER']);

        exit;

    }

}