<?php
require_once("./clases/Empleado.php");

$correo = isset($_POST["correo"]) ? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$id_perfil = isset($_POST["id_perfil"]) ? (int) $_POST["id_perfil"] : 0;
$foto = isset($_POST["foto"]) ? $_POST["foto"] : NULL;
$sueldo = isset($_POST["sueldo"]) ? (int) $_POST["sueldo"] : 0;

$empleado=new Empleado();
$empleado->correo=$correo;
$empleado->clave=$clave;
$empleado->nombre=$nombre;
$empleado->id_perfil=$id_perfil;
$empleado->sueldo=$sueldo;

$foto_name = $_FILES['foto']['name'];
$foto_tmp_name = $_FILES['foto']['tmp_name'];
$foto_extension = pathinfo($foto_name, PATHINFO_EXTENSION);
$hora = str_replace(':', '', date('H:i:s'));
$new_foto_name = $nombre . '.' . $hora. '.'. $foto_extension;    
$destinoFoto = "./empleados/fotos/" . $new_foto_name;    
$uploadOk = TRUE;   
if ($_FILES["foto"]["size"] > 5000000 ) {
   // echo "El archivo es demasiado grande. Verifique!!!";
    $uploadOk = FALSE;
}
$tipoArchivo = pathinfo($destinoFoto, PATHINFO_EXTENSION);
if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif"
    && $tipoArchivo != "png") {
   // echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
    $uploadOk = FALSE;
}

$empleado->foto = $destinoFoto;
//echo $empleado->foto;
if($uploadOk)
{
    if($empleado->Agregar())
    {
        if (move_uploaded_file($foto_tmp_name, $destinoFoto)) {
            //echo "LA foto  ". basename( $_FILES["foto"]["name"]). " ha sido subido exitosamente.";
        } else {
            //echo "Lamentablemente ocurriio un error y no se pudo subir el archivo.";
        }
        $respuesta = array('exito' => true, 'mensaje' => 'empleado agregado.');
    } else {
        $respuesta = array('exito' => false, 'mensaje' => 'empleado no agregado.');
    }
    echo json_encode($respuesta);
}
else
{
    echo json_encode( $respuesta = array('exito' => false, 'mensaje' => 'empleado no agregado problema con la foto.'));
}