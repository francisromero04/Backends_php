<?php
require_once "./clases/autoBD.php";
use RomeroFrancis\AutoBD;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $autos = AutoBD::Traer();

    echo "<table border=1>
        <tr>
            <th>Patente</th>
            <th>Marca</th>
            <th>Color</th>
            <th>Precio</th>
            <th>Foto</th>
        </tr>";

    foreach ($autos as $auto) {
        echo "
            <tr>
                <td>{$auto->Patente()}</td>
                <td>{$auto->Marca()}</td>
                <td>{$auto->Color()}</td>
                <td>{$auto->Precio()}</td>
                <td><img src=".$auto->PathFoto()." width='100px' height='100px'/></td>
            </tr>";
    }
    echo "</table>";
    // muestra en formato json a los usuarios    
} else {
    echo "Método no permitido";
}
?>