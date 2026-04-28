<?php

class OrcamentosController extends Controller {

public function salvar(){

    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);

    if(!$data){
        echo json_encode(["status"=>"erro","msg"=>"Sem dados"]);
        return;
    }

    $paciente = $data['paciente_id'] ?? null;
    $itens = $data['itens'] ?? [];

    if(empty($paciente) || empty($itens)){
        echo json_encode(["status"=>"erro","msg"=>"Dados inválidos"]);
        return;
    }

    require_once BASE_PATH . "/app/models/Orcamento.php";

    $model = new Orcamento();

    $orcamento_id = $model->salvar($paciente, $itens);

    echo json_encode([
        "status"=>"ok",
        "orcamento_id"=>$orcamento_id
    ]);
}
    // ===================================================

 public function ultimo($paciente)
{
    header('Content-Type: application/json');

    try {

        if(!$paciente){
            echo json_encode([
                "status" => "erro",
                "msg" => "Paciente não informado"
            ]);
            exit;
        }

        require_once BASE_PATH . "/app/models/Orcamento.php";

        $model = new Orcamento();

        $dados = $model->ultimo($paciente);

        // 🔥 GARANTE ARRAY
        if(!$dados){
            echo json_encode([]);
            exit;
        }

        echo json_encode($dados);

    } catch(Exception $e){

        echo json_encode([
            "status" => "erro",
            "msg" => $e->getMessage()
        ]);
    }

    exit;
}

    // ==============================================

public function aprovar()
{
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);
    $paciente_id = $data['paciente_id'] ?? null;

    if(!$paciente_id){
        echo json_encode([
            "status" => "erro",
            "msg" => "Paciente não enviado"
        ]);
        exit;
    }

    require_once BASE_PATH . "/app/models/Orcamento.php";
    require_once BASE_PATH . "/app/models/Prontuario.php";

    $orcModel = new Orcamento();
    $prontuarioModel = new Prontuario();

    // 🔥 pega último orçamento
    $orcamentos = $orcModel->listarPorPaciente($paciente_id);

    if(empty($orcamentos)){
        echo json_encode([
            "status" => "erro",
            "msg" => "Nenhum orçamento encontrado"
        ]);
        exit;
    }

    $orcamento = $orcamentos[0];

    // 🔥 aprova orçamento
    $orcModel->aprovar($orcamento['id']);

    // 🔥 pega itens
    $itens = $orcModel->itensDoOrcamento($orcamento['id']);

    foreach($itens as $item){

        $dados = [
            "paciente_id" => $paciente_id,
            "usuario_id" => $_SESSION['usuario_id'] ?? null,
            "tipo" => "procedimento",
            "dente" => $item['dente'] ?? null,
            "face" => null,
            "procedimento" => $item['procedimento'],
            "status" => "realizado",
            "observacoes" => "Aprovado via orçamento"
        ];

        $prontuarioModel->salvarRegistro($dados);
    }

    echo json_encode(["status" => "ok"]);
    exit;
}

// ===================================================

 public function limpar($paciente_id){

    header('Content-Type: application/json');

    require_once BASE_PATH . "/app/models/Orcamento.php";

    $model = new Orcamento();

    $ok = $model->limparPorPaciente($paciente_id);

    echo json_encode([
        "status" => $ok ? "ok" : "erro"
    ]);
}   

}