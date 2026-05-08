<?php

require_once BASE_PATH . "/app/models/Comissao.php";

class ComissoesController extends Controller
{

    /* ==========================
       LISTAGEM DE COMISSÕES
    ========================== */
    public function index()
    {
        // 🔥 PERÍODO PADRÃO
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fim = $_GET['fim'] ?? date('Y-m-d');

        // 🔥 GARANTE QUE O MODEL EXISTE
        if (!class_exists('Comissao')) {
            die("Erro: Model Comissao não encontrado.");
        }

        $model = new Comissao();

        // 🔥 SEGURANÇA (evita erro se método faltar)
        $comissoes = method_exists($model, 'listar')
            ? $model->listar($inicio, $fim)
            : [];

        $total = method_exists($model, 'totalPeriodo')
            ? $model->totalPeriodo($inicio, $fim)
            : 0;

        // 🔥 VIEW
        require BASE_PATH . "/app/views/layout/header.php";
        require BASE_PATH . "/app/views/financeiro/comissoes.php";
        require BASE_PATH . "/app/views/layout/footer.php";
    }


    /* ==========================
       RANKING DE DENTISTAS
    ========================== */
    public function ranking()
    {
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fim = $_GET['fim'] ?? date('Y-m-d');

        if (!class_exists('Comissao')) {
            die("Erro: Model Comissao não encontrado.");
        }

        $model = new Comissao();

        $ranking = method_exists($model, 'rankingDentistas')
            ? $model->rankingDentistas($inicio, $fim)
            : [];

        require BASE_PATH . "/app/views/layout/header.php";
        require BASE_PATH . "/app/views/financeiro/ranking.php";
        require BASE_PATH . "/app/views/layout/footer.php";
    }

}