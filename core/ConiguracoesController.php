<?php

class ConfiguracoesController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $nivel = $_SESSION['usuario_nivel'] ?? '';

        if($nivel != 'administrador'){
            die("Acesso negado.");
        }

        $this->view("configuracoes/index", [], "layout");
    }
}