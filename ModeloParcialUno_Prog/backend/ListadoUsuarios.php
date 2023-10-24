<?php   
require_once ("clases/Usuario.php");

if($_SERVER ['REQUEST_METHOD'] === 'GET')
{
    $usuarios = Usuario::TraerTodos();
    echo "<table border = 1>
        <tr>
            <th> nombre</th>
            <th> correo</th>
            <th> perfil</th>
        </tr>";

        foreach($usuarios as $usuario)
        {
            echo "
            <tr>
                <td> {$usuario->nombre}</td>
                <td> {$usuario->correo}</td>
                <td> {$usuario->perfil}</td>
            </tr>";
        }
        echo "</table>";
    //muestra en formato json a los usuarios
}else
{
    echo "Metodo no permitido";
}

?>