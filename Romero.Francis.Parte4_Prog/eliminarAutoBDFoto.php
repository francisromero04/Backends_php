<?php
require_once("./clases/autoBD.php");
use RomeroFrancis\AutoBD;

$auto_json = isset($_POST["auto_json"]) ? $_POST["auto_json"] : "sin json"; 

if(count($_POST) > 0 ){

    $autoObj = json_decode($auto_json);

    $neumaticoviejo = new AutoBD($autoObj->patente,$autoObj->marca,$autoObj->color,$autoObj->precio,$autoObj->pathFoto);
     
    $retorno ='{"exito" : false,"mensaje": "auto no borrado"}';
    
    if($neumaticoviejo->Eliminar($autoObj->patente)){    
        $neumatico = new AutoBD($autoObj->patente,$autoObj->marca,$autoObj->color,$autoObj->precio,$autoObj->pathFoto);
        if($neumatico->GuardarEnArchivo()){
            $retorno ='{"exito" : true,"mensaje": "auto borrado"}';
        }
    }
    
    echo $retorno;
         
}
else{
    if(file_exists("./archivos/autosbd_borrados.txt")){
    
    echo "
    <table >
        <thead>
            <tr>
                <th>patente</th>
                <th>marca</th>
                <th>color</th>
                <th>precio</th>
                <th>path</th>
                <th>foto</th>
            </tr>
        </thead>"; 
        $tabla = "";
        $contenido = file_get_contents('./archivos/autosbd_borrados.txt');
        $lineas = explode("\n", $contenido);
        foreach ($lineas as $linea) {
            // Dividir la línea en campos usando la coma como separador
            $campos = explode(',', $linea);
          
            // Crear una fila de la tabla con los datos
            echo '<tr>';
            foreach ($campos as $campo) {
              // Dividir el campo en clave y valor usando el dos puntos como separador
              $datos = explode(':', $campo);
             // if($datos[0]!=""){                
                $clave = trim($datos[0]);
                $valor = trim($datos[1]);
                if($clave == "foto"){
                    $valor .= '</td><td><img src=/prog_3/autos/imagenes/'.urlencode($valor).' width="200" height="200"></td>';
                }
             // }          
              // Mostrar el valor en la celda correspondiente
              echo '<td>' . $valor . '</td>';
            }
            echo '</tr>';
        }
        $tabla .= "</table>";
    
        echo $tabla;
    }
}

