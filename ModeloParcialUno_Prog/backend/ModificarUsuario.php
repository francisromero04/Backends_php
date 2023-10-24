<?php

require_once ("clases/Usuario.php");

$user = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : "sin user"; 
$usuarioOriginal = json_decode($user);

$usuarioModificado= new Usuario();
$usuarioModificado->id = $usuarioOriginal->id;
$usuarioModificado->correo = $usuarioOriginal->correo;
$usuarioModificado->clave = $usuarioOriginal->clave;
$usuarioModificado->nombre = $usuarioOriginal->nombre;
$usuarioModificado->id_perfil = $usuarioOriginal->id_perfil;

//var_dump($usuarioM);
if($usuarioModificado->Modificar())
{
    $respuesta = array('exito' => true, 'mensaje' => 'Usuario modificado correctamente.');
} else {
  $respuesta = array('exito' => false, 'mensaje' => 'Usuario no modificado, algo fallo.');
}
echo json_encode($respuesta);