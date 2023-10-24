<?php
include_once('ICRUD.php');
require_once("./clases/Usuario.php");

class Empleado extends Usuario implements ICRUD{

    public $foto;
    public $sueldo;

    public static function TraerTodos(){
        try{
            $conexion = new mysqli("localhost","root","","usuarios_test");
            if($conexion->connect_error)
            {
                return false;
            }

            $sql = "SELECT * FROM empleados";
            $stmt = $conexion->query($sql);
            $empleados = [];

            if($stmt->num_rows>0)
            {
                while($row = $stmt->fetch_assoc())
                {
                    $empleado = new Empleado();
                    $empleado->id = $row["id"];
                    $empleado->correo = $row["correo"];
                    $empleado->clave = $row["clave"];
                    $empleado->nombre = $row["nombre"];
                    $empleado->id_perfil = $row["id_perfil"];
                    $empleado->foto = $row["foto"];
                    $empleado->sueldo = $row["sueldo"];

                    $empleados[] = $empleado;
                }
            }

            $conexion->close();
            return $empleados;
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function Agregar(){
        try{
            $conexion = new mysqli("localhost","root","","usuarios_test");

            if($conexion->connect_error)
            {
                return false;
            }

            $sql = "INSERT INTO empleados(correo,clave,nombre,id_perfil,foto,sueldo) VALUES(?,?,?,?,?,?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssisi", $this->correo, $this->clave, $this->nombre, $this->id_perfil, $this->foto, $this->sueldo);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $stmt->close();
                $conexion->close();
             //   echo "empleado agregado con exito";
                return true;
            } else{
                $stmt->close();
                $conexion->close();
             //   echo "empleado no agregado";
                return false;
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function Modificar(): bool
    {
        $exito=false;
        try{
            $pdo= new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $sql=$pdo->prepare("UPDATE empleados SET nombre=:nombre,correo=:correo,clave=:clave,
                                id_perfil=:id_perfil,foto=:foto,sueldo=:sueldo WHERE id = :id");

            $sql->bindParam(':id',$this->id,PDO::PARAM_INT);
            $sql->bindParam(':correo',$this->correo,PDO::PARAM_STR,50);
            $sql->bindParam(':clave',$this->clave,PDO::PARAM_STR,8);
            $sql->bindParam(':nombre',$this->nombre,PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil',$this->id_perfil,PDO::PARAM_INT,10);
            $sql->bindParam(':foto',$this->foto,PDO::PARAM_STR,50);
            $sql->bindParam(':sueldo',$this->sueldo,PDO::PARAM_INT);

            $sql->execute();
            $exito=true;
        }catch(PDOException $e){

            echo $e->getMessage();
            $exito=false;

        }
        return $exito;
    }
    public static function Eliminar($id) //INTERFACE ICRUD
    {
        $conexion = new mysqli("localhost","root","","usuarios_test");

        if($conexion->connect_error)
        {
            return false;
        }

        $sql = "DELETE FROM empleados WHERE id=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close();
            $conexion->close();
            //echo "empleado eliminado con exito";
            return true; 
        } else {
            $stmt->close();
            $conexion->close();
            //echo "empleado no eliminado";
            return false; 
        }
    }
}

?>