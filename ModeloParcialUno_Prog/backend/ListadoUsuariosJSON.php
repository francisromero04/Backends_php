<?php   
require_once ("clases/Usuario.php");

if($_SERVER ['REQUEST_METHOD'] === 'GET')
{
    $usuarios = Usuario::TraerTodosJSON();
    //muestra en formato json a los usuarios
    echo json_encode($usuarios);
}
?>