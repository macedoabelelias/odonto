<?php

require_once BASE_PATH . "/app/models/Caixa.php";

class CaixaController extends Controller
{

    public function index()
    {
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fim    = $_GET['fim'] ?? date('Y-m-d');

        $model = new Caixa();

        $movimentos = $model->movimentoPeriodo($inicio, $fim);
        $resumo     = $model->resumoPeriodo($inicio, $fim);

        require BASE_PATH . "/app/views/layout/header.php";
        require BASE_PATH . "/app/views/financeiro/caixa.php";
        require BASE_PATH . "/app/views/layout/footer.php";
    }
}