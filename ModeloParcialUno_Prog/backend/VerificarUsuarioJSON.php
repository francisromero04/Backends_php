<?php   
require_once ("clases/Usuario.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén el JSON del campo 'usuario_json' de la solicitud POST
    if (isset($_POST['usuario_json'])) {
        $json = $_POST['usuario_json'];
        $usuario = json_decode($json);
        
        if (isset($usuario->correo) && isset($usuario->clave)) {
            $params = [
                'correo' => $usuario->correo,
                'clave' => $usuario->clave
            ];
            $resultado = Usuario::TraerUno($params);

            if ($resultado != null) {
                $respuesta = array('exito' => true, 'mensaje' => 'Usuario encontrado.');
            } else {
                $respuesta = array('exito' => false, 'mensaje' => 'Usuario no encontrado.');
            }
        } else {
            // Si falta alguno de los campos, devuelve un mensaje de error
            $respuesta = array('exito' => false, 'mensaje' => 'Faltan datos en la solicitud.');
        }
    } else {
        // Si no se encuentra el campo 'usuario_json', devuelve un mensaje de error
        $respuesta = array('exito' => false, 'mensaje' => 'Faltan datos en la solicitud (usuario_json).');
    }
} else {
    // Si no es una solicitud POST, devuelve un mensaje de error
    $respuesta = array('exito' => false, 'mensaje' => 'Solicitud no valida.');
}

// Devuelve la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);

?>