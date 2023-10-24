<?php   
require_once ("clases/Usuario.php");

if($_SERVER ['REQUEST_METHOD'] === 'POST')
{
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $nombre = $_POST['nombre'];
    $usuario = new Usuario();
    $usuario->correo = $correo;
    $usuario->clave = $clave;
    $usuario->nombre = $nombre;

    $resultado = $usuario->GuardarEnArchivo();
}
?>