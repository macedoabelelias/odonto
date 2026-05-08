<?php

class OrientacaoPaciente {

    private $pdo;

    public function __construct(){

        require BASE_PATH . "/config/conexao.php";

        $this->pdo = $pdo;

    }

    // =========================
    // SALVAR
    // =========================

    public function salvar($dados)
    {

        $sql = $this->pdo->prepare("
            INSERT INTO orientacoes_paciente
            (
                paciente_id,
                titulo,
                texto,
                imagem
            )
            VALUES
            (
                :paciente_id,
                :titulo,
                :texto,
                :imagem
            )
        ");

        return $sql->execute([

            ':paciente_id' => $dados['paciente_id'],
            ':titulo' => $dados['titulo'],
            ':texto' => $dados['texto'],
            ':imagem' => $dados['imagem']

        ]);

    }

    // =========================
    // ÚLTIMA ORIENTAÇÃO
    // =========================

    public function ultima($paciente_id)
    {

        $sql = $this->pdo->prepare("
            SELECT *
            FROM orientacoes_paciente
            WHERE paciente_id = :paciente
            ORDER BY id DESC
            LIMIT 1
        ");

        $sql->execute([
            ':paciente' => $paciente_id
        ]);

        return $sql->fetch(PDO::FETCH_ASSOC);

    }

}