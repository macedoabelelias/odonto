<?php

require_once BASE_PATH . "/app/models/Paciente.php";
require_once BASE_PATH . "/app/models/Financeiro.php";
require_once BASE_PATH . "/app/models/Usuario.php";
require_once BASE_PATH . "/app/models/Consulta.php";
require_once BASE_PATH . "/app/models/Produto.php"; // 🔥 NOVO

class DashboardController extends Controller
{
    public function index()
    {
        // 🔐 SEGURANÇA
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $nivel     = strtolower(trim($_SESSION['usuario_nivel'] ?? ''));
        $usuarioId = $_SESSION['usuario_id'] ?? null;

        // 📦 MODELS
        $pacienteModel   = new Paciente();
        $financeiroModel = new Financeiro();
        $usuarioModel    = new Usuario();
        $consultaModel   = new Consulta();
        $produtoModel    = new Produto(); // 🔥 NOVO

        $dataHoje = date('Y-m-d');

        /* ==========================
           CLÍNICA
        ========================== */

        $statsHoje = $consultaModel->estatisticasHoje();

        $consultasHoje = $statsHoje['total'] ?? 0;
        $atendidosHoje = $statsHoje['finalizado'] ?? 0;

        $agendaHoje = $consultaModel->listarPorData($dataHoje);

        $aniversariantesHoje = $pacienteModel->totalAniversariantesHoje();
        $aniversariantesMes  = $pacienteModel->totalAniversariantesMes();

        /* ==========================
           DENTISTA
        ========================== */

        $meusPacientes = 0;

        if ($nivel === 'dentista' && $usuarioId) {
            // futuro
        }

        /* ==========================
           FINANCEIRO
        ========================== */

        $contasReceberHoje = $financeiroModel->contasReceberHoje($dataHoje);
        $recebidoHoje      = $financeiroModel->recebidoHoje($dataHoje);
        $totalAberto       = $financeiroModel->totalEmAberto();

        $pagarHoje  = $financeiroModel->contasPagarHoje($dataHoje);
        $pagoHoje   = $financeiroModel->pagoHoje($dataHoje);
        $totalPagar = $financeiroModel->totalAPagar();

        $lucro = $financeiroModel->lucroMensal();

        /* ==========================
           GRÁFICOS
        ========================== */

        $grafico            = $financeiroModel->producaoMensal();
        $graficoComparativo = $financeiroModel->receitaVsDespesa();

        /* ==========================
           🔥 RANKING
        ========================== */

        $rankingDentistas = [];

        if (in_array($nivel, ['administrador', 'financeiro'])) {
            $rankingDentistas = $usuarioModel->rankingDentistasFaturamento();
        }

        if ($nivel === 'dentista' && $usuarioId) {
            $rankingDentistas = $usuarioModel->rankingPorDentista($usuarioId);
        }

        /* ==========================
           🔥 ESTOQUE BAIXO (NOVO)
        ========================== */

        $estoqueBaixo = $produtoModel->estoqueBaixo();

        /* ==========================
           VIEW
        ========================== */

        $dados = [
            // clínica
            "consultasHoje"        => (int) $consultasHoje,
            "atendidosHoje"        => (int) $atendidosHoje,
            "agendaHoje"           => $agendaHoje ?? [],
            "aniversariantesHoje"  => (int) $aniversariantesHoje,
            "aniversariantesMes"   => (int) $aniversariantesMes,
            "meusPacientes"        => (int) $meusPacientes,

            // financeiro
            "contasReceberHoje" => (float) $contasReceberHoje,
            "recebidoHoje"      => (float) $recebidoHoje,
            "totalAberto"       => (float) $totalAberto,
            "pagarHoje"         => (float) $pagarHoje,
            "pagoHoje"          => (float) $pagoHoje,
            "totalPagar"        => (float) $totalPagar,
            "lucro"             => $lucro ?? [],

            // gráficos
            "grafico"            => $grafico ?? [],
            "graficoComparativo" => $graficoComparativo ?? [],

            // ranking
            "rankingDentistas" => $rankingDentistas ?? [],

            // 🔥 NOVO
            "estoqueBaixo" => $estoqueBaixo ?? []
        ];

        $this->view("dashboard/index", $dados);
    }
}