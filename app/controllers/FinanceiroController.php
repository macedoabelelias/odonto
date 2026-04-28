

<?php

require_once BASE_PATH."/app/models/Financeiro.php";
require_once BASE_PATH."/app/models/ContaPagar.php";
require_once BASE_PATH."/app/models/ContaReceber.php";
require_once BASE_PATH."/app/models/Paciente.php";


class FinanceiroController extends Controller {

    /* ==========================
       DASHBOARD FINANCEIRO
    ========================== */
    public function index()
{
    require_once BASE_PATH . "/app/models/Financeiro.php";
    require_once BASE_PATH . "/app/models/ContaPagar.php";

    $model = new Financeiro();
    $vencidas = $model->contasPagarVencidas();
    $pagarModel = new ContaPagar();


    /* ==========================
       📊 GRÁFICOS
    ========================== */
    $grafico = $model->producaoMensal();
    $comparativo = $model->receitaVsDespesa();

    /* ==========================
       💰 RECEBER
    ========================== */
    $hoje = date('Y-m-d');

    $contasReceberHoje = $model->contasReceberHoje($hoje);
    $recebidoHoje = $model->recebidoHoje($hoje);
    $totalAberto = $model->totalEmAberto();

    /* ==========================
       💸 PAGAR
    ========================== */
    $resumoPagar = $pagarModel->resumoFinanceiro();

    $pagarHoje = $resumoPagar['hoje'] ?? 0;
    $pagoHoje = $resumoPagar['hoje'] ?? 0;
    $totalPagar = $resumoPagar['pendente'] ?? 0;

    /* ==========================
       📊 SALDO
    ========================== */
    $saldo = $recebidoHoje - $pagoHoje;

    /* ==========================
       📄 VIEW
    ========================== */
    require BASE_PATH . "/app/views/layout/header.php";
    require BASE_PATH . "/app/views/financeiro/dashboard.php";
    require BASE_PATH . "/app/views/layout/footer.php";
}

    /* ==========================
       CRIAR LANÇAMENTO MANUAL
    ========================== */
    public function criar(){

        $pacienteModel = new Paciente();
        $pacientes = $pacienteModel->listar();

        $this->view("financeiro/criar", [
            "pacientes" => $pacientes
        ]);
    }


    /* ==========================
       SALVAR LANÇAMENTO
    ========================== */
    public function salvar(){

        $model = new Financeiro();

        $model->registrar($_POST);

        header("Location: ".BASE_URL."/financeiro");
        exit;
    }


    /* ==========================
       CONTAS A PAGAR (TELA)
    ========================== */
    public function contas_pagar(){

        $model = new ContaPagar();
        $contas = $model->listar();

        $this->view('financeiro/pagar', [
            'contas' => $contas
        ]);
    }


    /* ==========================
       PAGAR CONTA
    ========================== */
    public function pagar_conta(){

        $id = $_POST['id'] ?? null;
        $forma = $_POST['forma'] ?? 'dinheiro';

        if(!$id){
            echo json_encode(['status'=>'erro']);
            return;
        }

        $model = new ContaPagar();

        // paga a conta
        $model->pagar($id, $forma);

        // 🔥 lança saída no caixa
        $financeiro = new Financeiro();

        $financeiro->registrar([
            'tipo' => 'saida',
            'categoria' => 'pagamento',
            'descricao' => 'Pagamento de conta ID '.$id,
            'valor' => $_POST['valor'] ?? 0,
            'data' => date('Y-m-d'),
            'forma_pagamento' => $forma,
            'usuario_id' => $_SESSION['usuario_id'] ?? null
        ]);

        echo json_encode(['status'=>'ok']);
    }

    public function relatorio()
{
    require_once BASE_PATH . "/vendor/dompdf/autoload.inc.php";

    $receber = new ContaReceber();
    $pagar = new ContaPagar();

    $resumoReceber = $receber->resumoFinanceiro();
    $resumoPagar = $pagar->resumoFinanceiro();

    $html = "
        <h2>Relatório Financeiro</h2>
        <hr>

        <h3>Contas a Receber</h3>
        <p>Recebido Hoje: R$ {$resumoReceber['hoje']}</p>
        <p>Pendente: R$ {$resumoReceber['pendente']}</p>

        <h3>Contas a Pagar</h3>
        <p>Pago Hoje: R$ {$resumoPagar['hoje']}</p>
        <p>Pendente: R$ {$resumoPagar['pendente']}</p>
    ";

    $dompdf = new \Dompdf\Dompdf(); // ✅ FUNCIONA SEM USE
    $dompdf->loadHtml($html);
    $dompdf->render();

    $dompdf->stream("relatorio_financeiro.pdf", ["Attachment"=>false]);
}
}