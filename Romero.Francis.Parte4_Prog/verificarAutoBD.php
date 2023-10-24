<?php
/*verificarAutoBD.php: Se recibe por POST el parámetro obj_auto, que será una cadena JSON (patente), si coincide
con algún registro de la base de datos (invocar al método traer) retornará los datos del objeto (invocar al toJSON).
Caso contrario, un JSON vacío ({}).*/

require_once("./clases/autoBD.php");
use RomeroFrancis\AutoBD;

$obj_auto = isset($_POST["obj_auto"]) ? $_POST["obj_auto"] : "sin obj_auto";
$auto_bd = json_decode($obj_auto);
$auto = new AutoBD($auto_bd->patente);


$array_auto = AutoBD::Traer();
$retorno = "{no se encontro}";

if($auto->Existe($array_auto)){
    $item = $auto->traerUno();
    if($item != null){        
        $retorno = $item->ToJSON();
    }
}

echo $retorno;