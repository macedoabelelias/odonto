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

    // 🔥 MODELS CORRETOS
    require_once BASE_PATH . "/app/models/Orcamento.php";
    require_once BASE_PATH . "/app/models/Prontuario.php";

    $orcModel = new Orcamento();
    $prontuarioModel = new Prontuario();

    // 🔥 SALVA ORÇAMENTO
    $orcamento_id = $orcModel->salvar($paciente, $itens);

    // 🔥 BUSCA ITENS SALVOS
    $itensSalvos = $orcModel->itensDoOrcamento($orcamento_id);

    // 🔥 SALVA SOMENTE PROCEDIMENTOS GERAIS
    foreach($itensSalvos as $item){

        if(empty($item['dente'])){

            $dados = [
                "paciente_id" => $paciente,
                "usuario_id" => $_SESSION['usuario_id'] ?? null,
                "tipo" => "procedimento",
                "dente" => null,
                "face" => null,
                "procedimento" => $item['procedimento'] ?? 'Procedimento',
                "status" => $item['status'] ?? "planejado",
                "observacoes" => "Via orçamento"
            ];

            $prontuarioModel->salvarRegistro($dados);
        }
    }

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
            echo json_encode([]);
            exit;
        }

        require_once BASE_PATH . "/app/models/Orcamento.php";

        $model = new Orcamento();

        // 🔥 pega último orçamento
        $orcamento = $model->ultimo($paciente);

        if(!$orcamento){
            echo json_encode([]);
            exit;
        }

        // 🔥 pega os itens do orçamento
        $itens = $model->itensDoOrcamento($orcamento['id']);

        // 🔥 RETORNA ARRAY (isso que o JS espera)
        echo json_encode($itens);

    } catch(Exception $e){

        echo json_encode([]);
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

    // 🔥 pega itens CORRETAMENTE
    $itens = $orcModel->itensDoOrcamento($orcamento['id']);

    foreach($itens as $item){

        // 🔥 SOMENTE PROCEDIMENTOS GERAIS (SEM DENTE)
        if(empty($item['dente'])){

            $dados = [
                "paciente_id" => $paciente_id,
                "usuario_id" => $_SESSION['usuario_id'] ?? null,
                "tipo" => "procedimento",
                "dente" => null,
                "face" => null,
                "procedimento" => $item['procedimento'] ?? 'Procedimento',
                "status" => $item['status'] ?? "realizado",
                "observacoes" => "Aprovado via orçamento"
            ];

            $prontuarioModel->salvarRegistro($dados);
        }
    }

    echo json_encode(["status" => "ok"]);
    exit;
}
    

public function listar($paciente_id)
{
    header('Content-Type: application/json');

    require_once BASE_PATH . "/app/models/Orcamento.php"; // 🔥 FALTAVA ISSO

    $model = new Orcamento();

    $dados = $model->listarPorPaciente((int)$paciente_id);

    echo json_encode($dados);
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

public function listarAgrupado($paciente_id)
{
    header('Content-Type: application/json');

    require_once BASE_PATH . "/app/models/Orcamento.php";

    $model = new Orcamento();

    $dados = $model->listarOrcamentosAgrupados((int)$paciente_id);

    echo json_encode($dados);
}

public function visualizar($orcamento_id)
{
    header('Content-Type: application/json');

    require_once BASE_PATH . "/app/models/Orcamento.php";

    $model = new Orcamento();

    $itens = $model->itensDoOrcamento((int)$orcamento_id);

    echo json_encode($itens);
    exit;
}

}