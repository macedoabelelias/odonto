<?php

require_once BASE_PATH . "/core/Model.php";

class Anamnese extends Model
{

    public function buscarPorPaciente($paciente_id)
    {

        $sql = $this->pdo->prepare("SELECT * FROM anamneses WHERE paciente_id = :paciente");
        $sql->bindValue(":paciente",$paciente_id);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }



    public function salvar($dados)
    {

        $sql = $this->pdo->prepare("

        INSERT INTO anamneses (

        paciente_id,
        diabetes,
        hipertensao,
        problema_cardiaco,
        alergias,
        quais_alergias,
        uso_medicamentos,
        quais_medicamentos,
        observacoes

        ) VALUES (?,?,?,?,?,?,?,?,?)

        ");

        return $sql->execute([

        $dados["paciente_id"],
        $dados["diabetes"],
        $dados["hipertensao"],
        $dados["problema_cardiaco"],
        $dados["alergias"],
        $dados["quais_alergias"],
        $dados["uso_medicamentos"],
        $dados["quais_medicamentos"],
        $dados["observacoes"]

        ]);

    }

}