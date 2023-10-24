<?php
require_once("clases/Usuario.php");
require_once("clases/Empleado.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $empleados = Empleado::TraerTodos();
    echo "<table border=1>
        <tr>
            <th>id</th>
            <th>correo</th>
            <th>clave</th>
            <th>nombre</th>
            <th>id perfil</th>
            <th>foto</th>
            <th>sueldo</th>
        </tr>";

    foreach ($empleados as $empleado) {
        echo "
            <tr>
                <td>{$empleado->id}</td>
                <td>{$empleado->correo}</td>
                <td>{$empleado->clave}</td>
                <td>{$empleado->nombre}</td>
                <td>{$empleado->id_perfil}</td>
                <td><img src='{$empleado->foto}' width='50' height='50'></td>
                <td>{$empleado->sueldo}</td>
            </tr>";
    }
    echo "</table>";
    // muestra en formato json a los usuarios    
} else {
    echo "Método no permitido";
}
?>