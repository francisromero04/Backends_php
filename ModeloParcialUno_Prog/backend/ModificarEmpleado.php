<?php

require_once("clases/Empleado.php");

$empleado = isset($_POST["empleado_json"]) ? $_POST["empleado_json"] : "sin empleado"; 
$empleadoOriginal = json_decode($empleado);

$empleadoModificado = new Empleado();
$empleadoModificado->id = $empleadoOriginal->id;
$empleadoModificado->correo = $empleadoOriginal->correo;
$empleadoModificado->clave = $empleadoOriginal->clave;
$empleadoModificado->nombre = $empleadoOriginal->nombre;
$empleadoModificado->id_perfil = $empleadoOriginal->id_perfil;

// Verifica si la propiedad "foto" está definida en el objeto $empleadoOriginal
if (isset($empleadoOriginal->foto)) {
    $empleadoModificado->foto = $empleadoOriginal->foto;
}

$empleadoModificado->sueldo = $empleadoOriginal->sueldo;

if ($empleadoModificado->Modificar()) {
    $respuesta = array('exito' => true, 'mensaje' => 'Empleado modificado correctamente.');
} else {
    $respuesta = array('exito' => false, 'mensaje' => 'Empleado no modificado, algo falló.');
}
echo json_encode($respuesta);
?>