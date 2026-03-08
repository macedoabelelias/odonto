<?php

class DashboardController extends Controller {

    public function index() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if(!isset($_SESSION['usuario_id'])){
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $mesAtual = date('Y-m');

        $recebido = $this->pdo->query("
            SELECT SUM(valor) as total 
            FROM financeiro 
            WHERE tipo='Receita'
            AND DATE_FORMAT(data,'%Y-%m')='$mesAtual'
        ")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $pago = $this->pdo->query("
            SELECT SUM(valor) as total 
            FROM financeiro 
            WHERE tipo='Despesa'
            AND DATE_FORMAT(data,'%Y-%m')='$mesAtual'
        ")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $compras = $this->pdo->query("
            SELECT SUM(valor_total) as total 
            FROM compras
            WHERE DATE_FORMAT(data_compra,'%Y-%m')='$mesAtual'
        ")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $pacientes = $this->pdo->query("
            SELECT COUNT(*) as total 
            FROM pacientes
        ")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $estoqueBaixo = $this->pdo->query("
            SELECT *
            FROM produtos
            WHERE estoque <= estoque_minimo
        ")->fetchAll(PDO::FETCH_ASSOC);

        $grafico = $this->pdo->query("
            SELECT 
                DATE_FORMAT(data,'%m/%Y') as mes,
                SUM(CASE WHEN tipo='Receita' THEN valor ELSE 0 END) as receita,
                SUM(CASE WHEN tipo='Despesa' THEN valor ELSE 0 END) as despesa
            FROM financeiro
            WHERE data >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(data,'%Y-%m')
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

        $this->view("dashboard", [
            'recebido' => $recebido,
            'pago' => $pago,
            'compras' => $compras,
            'pacientes' => $pacientes,
            'estoqueBaixo' => $estoqueBaixo,
            'labels' => $labels,
            'receitas' => $receitas,
            'despesas' => $despesas
        ]);

    }
}