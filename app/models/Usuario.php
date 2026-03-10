<?php

require_once BASE_PATH . "/core/Database.php";

class Usuario {

private $pdo;

public function __construct(){
$this->pdo = Database::getConnection();
}

/* LISTAR */

public function listar(){

$sql = $this->pdo->query("SELECT * FROM usuarios ORDER BY nome");
return $sql->fetchAll(PDO::FETCH_ASSOC);

}

/* BUSCAR POR ID */

public function buscar($id){

$sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id=:id");
$sql->bindValue(":id",$id);
$sql->execute();

return $sql->fetch(PDO::FETCH_ASSOC);

}

/* BUSCAR POR EMAIL */

public function buscarPorEmail($email){

$sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE email=:email");
$sql->bindValue(":email",$email);
$sql->execute();

return $sql->fetch(PDO::FETCH_ASSOC);

}

/* CRIAR */

public function criar($dados){

$senha = password_hash($dados["senha"], PASSWORD_DEFAULT);

$sql = $this->pdo->prepare("

INSERT INTO usuarios
(nome,email,senha,nivel)
VALUES
(:nome,:email,:senha,:nivel)

");

$sql->bindValue(":nome",$dados["nome"]);
$sql->bindValue(":email",$dados["email"]);
$sql->bindValue(":senha",$senha);
$sql->bindValue(":nivel",$dados["nivel"]);

return $sql->execute();

}

/* EDITAR */

public function atualizar($dados){

$sql = $this->pdo->prepare("

UPDATE usuarios SET
nome=:nome,
email=:email,
nivel=:nivel
WHERE id=:id

");

$sql->bindValue(":nome",$dados["nome"]);
$sql->bindValue(":email",$dados["email"]);
$sql->bindValue(":nivel",$dados["nivel"]);
$sql->bindValue(":id",$dados["id"]);

return $sql->execute();

}

/* EXCLUIR */

public function excluir($id){

$sql = $this->pdo->prepare("DELETE FROM usuarios WHERE id=:id");
$sql->bindValue(":id",$id);

return $sql->execute();

}

/* ALTERAR SENHA */

public function alterarSenha($id,$senha){

$senha = password_hash($senha,PASSWORD_DEFAULT);

$sql = $this->pdo->prepare("

UPDATE usuarios SET senha=:senha WHERE id=:id

");

$sql->bindValue(":senha",$senha);
$sql->bindValue(":id",$id);

return $sql->execute();

}

}