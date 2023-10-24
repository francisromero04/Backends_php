<?php

require_once("./clases/Empleado.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];    
    $resultado = Empleado::Eliminar($id);

    if ($resultado != null) {
        $respuesta = array('exito' => true, 'mensaje' => 'Empleado eliminado.');
    } else {
        $respuesta = array('exito' => false, 'mensaje' => 'Empleado no eliminado.');
    }
   
} else {
    $respuesta = array('exito' => false, 'mensaje' => 'Faltan datos en la solicitud (usuario_json).');
}

echo json_encode($respuesta);
