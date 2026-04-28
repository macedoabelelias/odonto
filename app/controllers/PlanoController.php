<?php

require_once __DIR__ . '/../models/PlanoTratamento.php';
require_once __DIR__ . '/../models/EvolucaoClinica.php';

class PlanoController extends Controller
{

    public function salvar()
    {
        $model = new PlanoTratamento();

        $dados = [

            "paciente_id" => $_POST['paciente_id'] ?? null,
            "usuario_id"  => $_SESSION['usuario_id'] ?? null,
            "dente"       => $_POST['dente'] ?? null,
            "procedimento"=> $_POST['procedimento'] ?? '',
            "valor"       => $_POST['valor'] ?? 0,
            "observacoes" => $_POST['observacoes'] ?? null,
            "status"      => "planejado"

        ];

        // 🔥 SALVA PLANO
        $model->criar($dados);

        // 🔥 REGISTRA NA EVOLUÇÃO
        $evolucaoModel = new EvolucaoClinica();

        $texto = "Procedimento planejado: {$dados['procedimento']}";

        if(!empty($dados['dente'])){
            $texto .= " (Dente {$dados['dente']})";
        }

        $evolucaoModel->salvar([
            "paciente_id"     => $dados['paciente_id'],
            "procedimento_id" => null,
            "status"          => "planejado",
            "observacao"      => $texto
        ]);

        header("Location: ".BASE_URL."/prontuarios/index/".$dados['paciente_id']);
        exit;
    }

public function atualizarStatus()
{
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? 'planejado';

    if(!$id){
        header("Location: " . BASE_URL . "/pacientes");
        exit;
    }

    require_once BASE_PATH."/app/models/Orcamento.php";
    require_once BASE_PATH."/app/models/EvolucaoClinica.php";

    $model = new Orcamento();

    // 🔥 ATUALIZA STATUS
    $model->atualizarStatusItem($id, $status);

    // 🔥 BUSCA DADOS
    $item = $model->buscarItem($id);

    // 🔥 EVOLUÇÃO
    if($item){
        $evolucao = new EvolucaoClinica();

        $texto = "Status alterado: {$item['procedimento']}";

        if(!empty($item['dente'])){
            $texto .= " (Dente {$item['dente']})";
        }

        $texto .= " → {$status}";

        $evolucao->salvar([
            "paciente_id"     => $item['paciente_id'],
            "procedimento_id" => null,
            "status"          => $status,
            "observacao"      => $texto
        ]);
    }

    header("Location: " . BASE_URL . "/prontuarios/index/" . $item['paciente_id']);
    exit;
}

}