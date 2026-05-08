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

    $sql->execute([

        ':paciente_id' =>
            $dados['paciente_id'],

        ':titulo' =>
            $dados['titulo'],

        ':texto' =>
            $dados['texto'],

        ':imagem' =>
            $dados['imagem']

    ]);

    // 🔥 RETORNA ID
    return $this->pdo->lastInsertId();

}
    // =========================
    // ÚLTIMA ORIENTAÇÃO
    // =========================

public function buscarUltima($paciente_id)
{

    $sql = $this->pdo->prepare("

        SELECT *
        FROM orientacoes_paciente
        WHERE paciente_id = :paciente
        ORDER BY id DESC
        LIMIT 1

    ");

    $sql->bindValue(
        ':paciente',
        $paciente_id,
        PDO::PARAM_INT
    );

    $sql->execute();

    return $sql->fetch(PDO::FETCH_ASSOC);

}

public function salvarArquivo($dados)
{

    $sql = $this->pdo->prepare("

        INSERT INTO orientacoes_arquivos (

            orientacao_id,
            arquivo

        ) VALUES (

            :orientacao,
            :arquivo

        )

    ");

    return $sql->execute([

        ':orientacao' =>
            $dados['orientacao_id'],

        ':arquivo' =>
            $dados['arquivo']

    ]);

}

public function listarArquivos($orientacao_id)
{

    $sql = $this->pdo->prepare("

        SELECT *
        FROM orientacoes_arquivos
        WHERE orientacao_id = :orientacao
        ORDER BY id DESC

    ");

    $sql->execute([

        ':orientacao' => $orientacao_id

    ]);

    return $sql->fetchAll(PDO::FETCH_ASSOC);

}

}