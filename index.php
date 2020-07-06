<?php

require_once("config.php");

#$sql = new Sql();

#$usuario = $sql->select("SELECT * FROM tb_usuario");

#echo json_encode($usuario);

/*Carrega um usuário
$root = new Usuario();
$root->loadById(3);*/
//echo $root;

//Carrega uma lista de usuário
//$lista = Usuario::getList();
//echo json_encode($lista);

//Carrega uma lista de usuarios buscando pelo login

//$search = Usuario::search("ro");
//echo json_encode($search);

$usuario = new Usuario();
$usuario->login("Marcos", "qwerty");

echo $usuario;

?>