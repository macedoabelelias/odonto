<?php

class DashboardController extends Controller {

    public function index() {

        // 🔐 Verifica login
        require_once BASE_PATH . "/config/autenticarpainel.php";

        // 🔌 Conexão
        require_once BASE_PATH . "/config/conexao.php";

        // 🗓 Mês atual
        $mesAtual = date('Y-m');

        // 💰 Total Recebido no mês
        $recebido = $pdo->query("
            SELECT SUM(valor) as total 
            FROM financeiro 
            WHERE tipo='Receita' 
            AND DATE_FORMAT(data, '%Y-%m') = '$mesAtual'
        ")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // 💸 Total Pago no mês
        $pago = $pdo->query("
            SELECT SUM(valor) as total 
            FROM financeiro 
            WHERE tipo='Despesa' 
            AND DATE_FORMAT(data, '%Y-%m') = '$mesAtual'
        ")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // 🛒 Total Compras no mês
        $compras = $pdo->query("
            SELECT SUM(valor_total) as total 
            FROM compras 
            WHERE DATE_FORMAT(data_compra, '%Y-%m') = '$mesAtual'
        ")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // 👥 Total Pacientes
        $pacientes = $pdo->query("
            SELECT COUNT(*) as total 
            FROM pacientes
        ")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // 📦 Produtos com estoque baixo
        $estoqueBaixo = $pdo->query("
            SELECT * 
            FROM produtos 
            WHERE estoque <= estoque_minimo
        ")->fetchAll(PDO::FETCH_ASSOC);

        // 📊 Dados gráfico últimos 6 meses
        $grafico = $pdo->query("
            SELECT 
                DATE_FORMAT(data, '%m/%Y') as mes,
                SUM(CASE WHEN tipo='Receita' THEN valor ELSE 0 END) as receita,
                SUM(CASE WHEN tipo='Despesa' THEN valor ELSE 0 END) as despesa
            FROM financeiro
            WHERE data >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(data, '%Y-%m')
            ORDER BY data ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $receitas = [];
        $despesas = [];

        foreach($grafico as $g){
            $labels[] = $g['mes'];
            $receitas[] = $g['receita'];
            $despesas[] = $g['despesa'];
        }

        // ⚙ Configuração do sistema (logo + nome clínica)
        $configSistema = $pdo->query("
            SELECT * 
            FROM configuracoes 
            LIMIT 1
        ")->fetch(PDO::FETCH_ASSOC);

        // 👤 Nível do usuário
        $nivel = $_SESSION['usuario_nivel'] ?? '';

        // 📦 Envia tudo para a view
        $this->view("dashboard", [
            'recebido' => $recebido,
            'pago' => $pago,
            'compras' => $compras,
            'pacientes' => $pacientes,
            'estoqueBaixo' => $estoqueBaixo,
            'labels' => $labels,
            'receitas' => $receitas,
            'despesas' => $despesas,
            'configSistema' => $configSistema,
            'nivel' => $nivel
        ]);
    }
}