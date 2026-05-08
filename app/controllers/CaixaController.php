<?php

require_once BASE_PATH . "/app/models/Caixa.php";

class CaixaController extends Controller
{

    public function index()
    {
        $data = $_GET['data'] ?? date('Y-m-d');

        $model = new Caixa();

        $movimentos = $model->movimentoDia($data);
        $resumo = $model->resumoDia($data);

        require BASE_PATH . "/app/views/layout/header.php";
        require BASE_PATH . "/app/views/financeiro/caixa.php";
        require BASE_PATH . "/app/views/layout/footer.php";
    }
}