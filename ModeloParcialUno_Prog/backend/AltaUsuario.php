<?php

require_once ("clases/Usuario.php");

// Verifica que se haya recibido una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos recibidos por POST
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $nombre = $_POST['nombre'];
    $id_perfil = $_POST['id_perfil'];

    // Crea una instancia de la clase Usuario
    $usuario = new Usuario();

    // Establece los valores de las propiedades del usuario
    $usuario->correo = $correo;
    $usuario->clave = $clave;
    $usuario->nombre = $nombre;
    $usuario->id_perfil = $id_perfil;

    // Llama a la función Agregar para intentar agregar el usuario
    if ($usuario->Agregar()) {
        // La función Agregar retornó true, lo que significa que el usuario se agregó con éxito
        $response = array('exito' => true, 'mensaje' => 'Usuario agregado con exito');
    } else {
        // La función Agregar retornó false, lo que significa que hubo un error al agregar el usuario
        $response = array('exito' => false, 'mensaje' => 'Error al agregar el usuario');
    }
} else {
    // Si no se recibió una solicitud POST, devuelve un mensaje de error
    $response = array('exito' => false, 'mensaje' => 'Solicitud no valida');
}

// Devuelve la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>