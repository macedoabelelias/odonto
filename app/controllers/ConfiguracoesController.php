<?php

class ConfiguracoesController extends Controller{

/* ==============================
   ABRIR CONFIGURAÇÕES
============================== */

public function index(){

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 🔥 NORMALIZAÇÃO (PADRÃO DO SISTEMA)
    $nivel = strtolower(trim($_SESSION['usuario_nivel'] ?? ''));

    // 🔐 SOMENTE ADMIN
    if($nivel !== 'administrador'){
        die("Acesso negado");
    }

    require BASE_PATH . "/config/conexao.php";

    // BUSCAR CONFIGURAÇÕES
    $sql = $pdo->query("SELECT * FROM configuracoes LIMIT 1");
    $config = $sql->fetch(PDO::FETCH_ASSOC);

    // SE NÃO EXISTIR
    if(!$config){

        $pdo->query("
            INSERT INTO configuracoes (nome_clinica, logo)
            VALUES ('Minha Clínica','')
        ");

        $sql = $pdo->query("SELECT * FROM configuracoes LIMIT 1");
        $config = $sql->fetch(PDO::FETCH_ASSOC);
    }

    // 🔥 COM LAYOUT (IMPORTANTE)
    $this->view("configuracoes/index", [
        "config"=>$config
    ], "layout");
}


/* ==============================
   SALVAR CONFIGURAÇÕES
============================== */

public function salvar(){

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $nivel = strtolower(trim($_SESSION['usuario_nivel'] ?? ''));

    if($nivel !== 'administrador'){
        die("Acesso negado");
    }

    require BASE_PATH . "/config/conexao.php";

    // 🔥 BUSCAR CONFIG (COM SEGURANÇA)
    $sql = $pdo->query("SELECT * FROM configuracoes LIMIT 1");
    $config = $sql->fetch(PDO::FETCH_ASSOC);

    if(!$config){
        die("Erro: configuração não encontrada");
    }

    $id = $config['id'];

    /* ================= DADOS ================= */

    $nome       = $_POST['nome_clinica'] ?? '';
    $documento  = $_POST['documento'] ?? null;
    $telefone   = $_POST['telefone'] ?? '';
    $cep        = $_POST['cep'] ?? '';
    $endereco   = $_POST['endereco'] ?? '';
    $numero     = $_POST['numero'] ?? '';
    $bairro     = $_POST['bairro'] ?? '';
    $cidade     = $_POST['cidade'] ?? '';
    $estado     = $_POST['estado'] ?? '';

    /* ================= LOGO ================= */

    $logo = $config['logo'] ?? '';

    if(!empty($_FILES['logo']['name'])){

        $nomeLogo = time()."_".basename($_FILES['logo']['name']);

        move_uploaded_file(
            $_FILES['logo']['tmp_name'],
            BASE_PATH."/public/assets/img/".$nomeLogo
        );

        $logo = $nomeLogo;
    }

    /* ================= UPDATE ================= */

    $sql = "UPDATE configuracoes SET
        nome_clinica = :nome,
        documento = :documento,
        telefone = :telefone,
        cep = :cep,
        endereco = :endereco,
        numero = :numero,
        bairro = :bairro,
        cidade = :cidade,
        estado = :estado,
        logo = :logo
    WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(":nome", $nome);
    $stmt->bindValue(":documento", $documento);
    $stmt->bindValue(":telefone", $telefone);
    $stmt->bindValue(":cep", $cep);
    $stmt->bindValue(":endereco", $endereco);
    $stmt->bindValue(":numero", $numero);
    $stmt->bindValue(":bairro", $bairro);
    $stmt->bindValue(":cidade", $cidade);
    $stmt->bindValue(":estado", $estado);
    $stmt->bindValue(":logo", $logo);
    $stmt->bindValue(":id", $id);

    // 🔥 EXECUTA COM VERIFICAÇÃO
    if(!$stmt->execute()){
        die("Erro ao salvar configuração");
    }

    header("Location: ?url=configuracoes");
    exit;
}
}