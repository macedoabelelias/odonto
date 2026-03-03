<?php

require_once BASE_PATH . "/app/models/Usuario.php";

class UsuariosController extends Controller
{
    public function perfil()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscarPorId($_SESSION['usuario_id']);

        $this->view("usuarios/perfil", [
            'usuario' => $usuario
        ]);
    }

    public function atualizarPerfil()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $usuarioModel = new Usuario();

        $dados = [
            'nome' => $_POST['nome'],
            'senha' => $_POST['senha'] ?? ''
        ];

        $usuarioModel->atualizarPerfil($_SESSION['usuario_id'], $dados);

        $_SESSION['usuario_nome'] = $_POST['nome'];

        header("Location: " . BASE_URL . "/usuarios/perfil");
        exit;
    }
}