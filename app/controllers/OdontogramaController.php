<?php

require_once BASE_PATH . "/app/models/Odontograma.php";

class OdontogramaController extends Controller
{
    public function salvar()
    {
        $dados = json_decode(file_get_contents("php://input"), true);

        $model = new Odontograma();
        $model->salvar($dados);

        echo "ok";
    }
}