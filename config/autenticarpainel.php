<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "/login");
    exit;
}

function somenteAdmin() {
    if (!isset($_SESSION['usuario_nivel']) || $_SESSION['usuario_nivel'] !== 'admin') {
        echo "<h3 style='padding:20px'>Acesso restrito ao administrador.</h3>";
        exit;
    }
}