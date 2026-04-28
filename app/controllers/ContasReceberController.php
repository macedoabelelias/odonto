<?php

require_once BASE_PATH . "/app/models/ContaReceber.php";
require_once BASE_PATH . "/app/models/Paciente.php";
require_once BASE_PATH . "/app/models/Comissao.php";
require_once BASE_PATH . "/app/models/Usuario.php";
require_once BASE_PATH . "/app/models/Convenio.php";

class ContasReceberController extends Controller
{

    /* ==========================
       LISTAR CONTAS
    ========================== */
    public function index($filtro = null)
    {
        $model = new ContaReceber();

        $busca = $_GET['busca'] ?? null;

        $contas = $model->listar($filtro, $busca);
        $resumo = $model->resumoFinanceiro();

        $this->view("financeiro/contas_receber", [
            "contas" => $contas,
            "resumo" => $resumo,
            "busca" => $busca
        ]);
    }


    /* ==========================
       FORM NOVA CONTA
    ========================== */
    public function criar()
    {
        $pacienteModel = new Paciente();
        $pacientes = $pacienteModel->listar();

        $usuarioModel = new Usuario();
        $dentistas = $usuarioModel->listarDentistas();

        $convenioModel = new Convenio();
        $convenios = $convenioModel->listar();

        $this->view("financeiro/contas_receber_nova", [
            "pacientes" => $pacientes,
            "dentistas" => $dentistas,
            "convenios" => $convenios
        ]);
    }


    /* ==========================
       SALVAR CONTA
    ========================== */
    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?url=contasReceber");
            exit;
        }

        $paciente_id     = $_POST['paciente_id'] ?? null;
        $profissional_id = $_POST['profissional_id'] ?? null;

        if (empty($paciente_id) || empty($profissional_id)) {
            $_SESSION['erro'] = "Selecione paciente e dentista.";
            header("Location: ?url=contasReceber/criar");
            exit;
        }

        $dados = [
            "paciente_id"     => $paciente_id,
            "profissional_id" => $profissional_id,
            "descricao"       => $_POST['descricao'] ?? '',
            "valor"           => $_POST['valor'] ?? 0,
            "data_vencimento" => $_POST['data_vencimento'] ?? date('Y-m-d'),
            "convenio_id"     => $_POST['convenio_id'] ?? null
        ];

        $model = new ContaReceber();

        try {
            $model->criar($dados);
        } catch (Exception $e) {
            die("Erro ao salvar: " . $e->getMessage());
        }

        header("Location: ?url=contasReceber");
        exit;
    }


    /* ==========================
       RECEBER (💰 + 👨‍⚕️ COMISSÃO)
    ========================== */
    public function receber($id)
    {
        $forma = $_POST['forma_pagamento'] ?? 'dinheiro';

        $model = new ContaReceber();
        $conta = $model->buscar($id);

        if (!$conta) {
            header("Location: ?url=contasReceber");
            exit;
        }

        // 🔥 marca como pago
        $model->marcarComoPago($id, $forma);

        /* ==========================
           💰 CAIXA
        ========================== */
        require_once BASE_PATH . "/app/models/Financeiro.php";

        $financeiro = new Financeiro();

        $financeiro->registrar([
            'tipo' => 'entrada',
            'categoria' => 'recebimento',
            'descricao' => 'Recebimento de conta ID ' . $id,
            'valor' => $conta['valor'],
            'data' => date('Y-m-d'),
            'forma_pagamento' => $forma,
            'usuario_id' => $_SESSION['usuario_id'] ?? null
        ]);

        /* ==========================
           👨‍⚕️ COMISSÃO
        ========================== */
        $comissaoModel = new Comissao();
        $comissaoModel->registrar($id);

        header("Location: ?url=contasReceber");
        exit;
    }


    /* ==========================
       RECIBO
    ========================== */
    public function recibo($id)
    {
        $model = new ContaReceber();
        $conta = $model->buscar($id);

        if (!$conta) {
            echo "Recibo não encontrado";
            exit;
        }

        extract(["conta" => $conta]);
        require BASE_PATH . "/app/views/financeiro/recibo.php";
    }


    /* ==========================
       EXCLUIR
    ========================== */
    public function excluir($id)
    {
        $model = new ContaReceber();
        $model->excluir($id);

        header("Location: ?url=contasReceber");
        exit;
    }
}