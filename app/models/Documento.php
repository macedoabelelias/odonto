<?php

class Documento extends Model {

    /* ==========================
       SALVAR DOCUMENTO
    ========================== */

    public function salvar($paciente_id, $tipo, $arquivo) {

        $usuario_id = $_SESSION['usuario_id'] ?? null;

        $sql = $this->pdo->prepare("
            INSERT INTO documentos_paciente
            (paciente_id, usuario_id, nome_arquivo, arquivo, tipo, data_upload)
            VALUES
            (:paciente, :usuario, :nome, :arquivo, :tipo, NOW())
        ");

        $sql->bindValue(":paciente", $paciente_id);
        $sql->bindValue(":usuario", $usuario_id);
        $sql->bindValue(":nome", $arquivo);
        $sql->bindValue(":arquivo", $arquivo);
        $sql->bindValue(":tipo", $tipo);

        return $sql->execute();
    }

    /* ==========================
       LISTAR POR PACIENTE
    ========================== */

    public function listarPorPaciente($paciente_id) {

        $sql = $this->pdo->prepare("
            SELECT *
            FROM documentos_paciente
            WHERE paciente_id = :paciente
            ORDER BY data_upload DESC
        ");

        $sql->bindValue(":paciente", $paciente_id);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

}