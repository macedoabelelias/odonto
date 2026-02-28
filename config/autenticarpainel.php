<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se não estiver logado, volta para login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}