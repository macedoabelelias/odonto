<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "odonto";

try {

    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2>Instalador do Sistema Odonto</h2>";

    // Criar banco
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "Banco de dados criado ou já existente.<br>";

    $pdo->exec("USE $dbname");

    // Tabela usuarios
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(150) NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL,
            nivel ENUM('admin','dentista','recepcao') DEFAULT 'dentista',
            foto VARCHAR(255),
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo "Tabela usuarios criada.<br>";

    // Tabela pacientes
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS pacientes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(150) NOT NULL,
            cpf VARCHAR(14),
            nascimento DATE,
            telefone VARCHAR(20),
            email VARCHAR(150),
            endereco VARCHAR(255),
            foto VARCHAR(255),
            observacoes TEXT,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo "Tabela pacientes criada.<br>";

    // Tabela prontuarios
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS prontuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            paciente_id INT NOT NULL,
            usuario_id INT NOT NULL,
            data_atendimento DATE,
            tipo_denticao VARCHAR(50),
            procedimento VARCHAR(255),
            observacoes TEXT,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        )
    ");

    echo "Tabela prontuarios criada.<br>";

    // Tabela odontograma
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS odontograma (
            id INT AUTO_INCREMENT PRIMARY KEY,
            paciente_id INT NOT NULL,
            dente INT NOT NULL,
            procedimento VARCHAR(100),
            status ENUM('a_realizar','realizado') DEFAULT 'a_realizar',
            observacao TEXT,
            data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE
        )
    ");

    echo "Tabela odontograma criada.<br>";

    // Tabela financeiro
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS financeiro (
            id INT AUTO_INCREMENT PRIMARY KEY,
            paciente_id INT,
            descricao VARCHAR(255),
            valor DECIMAL(10,2),
            tipo ENUM('entrada','saida'),
            status ENUM('pendente','pago') DEFAULT 'pendente',
            data_registro DATE,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE SET NULL
        )
    ");

    echo "Tabela financeiro criada.<br>";

    // Criar admin
    $senha = password_hash("123456", PASSWORD_DEFAULT);

    $verifica = $pdo->query("SELECT id FROM usuarios WHERE email='admin@admin.com'")->fetch();

    if(!$verifica){

        $stmt = $pdo->prepare("INSERT INTO usuarios (nome,email,senha,nivel) VALUES (?,?,?,?)");
        $stmt->execute([
            "Administrador",
            "admin@admin.com",
            $senha,
            "admin"
        ]);

        echo "Usuário administrador criado.<br>";

    } else {

        echo "Usuário administrador já existe.<br>";

    }

    echo "<br><b>Instalação finalizada com sucesso!</b>";

} catch(PDOException $e){

    echo "Erro: " . $e->getMessage();

}