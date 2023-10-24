<?php

require_once ("clases/Usuario.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $id = $_POST['id'];
    
    if ($accion === 'borrar') {
        $resultado = Usuario::Eliminar($id);

        if ($resultado != null) {
            $respuesta = array('exito' => true, 'mensaje' => 'Usuario eliminado.');
        } else {
            $respuesta = array('exito' => false, 'mensaje' => 'Usuario no eliminado.');
        }
    } else {
        // Si falta alguno de los campos, devuelve un mensaje de error
        $respuesta = array('exito' => false, 'mensaje' => 'Faltan datos en la solicitud.');
    }
} else {
    // Si no se encuentra el campo 'usuario_json', devuelve un mensaje de error
    $respuesta = array('exito' => false, 'mensaje' => 'Faltan datos en la solicitud (usuario_json).');
}

// Devuelve la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
