<?php
include_once('IBM.php');

class Usuario implements IBM{
    public $id;
    public $nombre;
    public $correo;
    public $clave;
    public $id_perfil;
    public $perfil;

    public function __construct() {
        
    }

    public function __toString() {
        return "Usuario(id={$this->id}, nombre='{$this->nombre}', correo='{$this->correo}', clave='{$this->clave}', id_perfil={$this->id_perfil}, perfil='{$this->perfil}')";
    }

    public function ToJSON() {
        $data = array(
            "nombre" => $this->nombre,
            "correo" => $this->correo,
            "clave" => $this->clave
        ); //array asociativo
        return json_encode($data);
    }

    public function GuardarEnArchivo(){
        $usuarios = json_decode(file_get_contents('archivos/usuarios.json'), true);
        $usuarios[] = json_decode($this->ToJSON(), true);
        $resultado = file_put_contents('archivos/usuarios.json',json_encode($usuarios));

        if($resultado === false)
        {          
            return json_encode(array("exito" =>false, "mensaje"=>"Errore al agregar el usuario"));
        }
        else{
            return json_encode(array("exito" => true, "mensaje" => "se agrego el usuario correctamente"));
        }
    }

    public static function TraerTodosJSON(){
        $usuariosJSON = json_decode(file_get_contents('archivos/usuarios.json'), true);
        $usuarios = [];

        foreach($usuariosJSON as $usuarioIndividal)
        {
            $usuario = new Usuario();
            $usuario->nombre = $usuarioIndividal["nombre"];
            $usuario->correo = $usuarioIndividal["correo"];
            $usuario->clave = $usuarioIndividal["clave"];
            $usuarios[] = $usuario;
        }
        return $usuarios;
    }

    public function Agregar(){
        $conexion = new mysqli("localhost","root","","usuarios_test");
        if($conexion->connect_error)
        {
            return false;
        }

        $sql = "INSERT INTO usuarios(correo,clave,nombre,id_perfil) VALUES(?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $this->correo, $this->clave, $this->nombre, $this->id_perfil);
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close();
            $conexion->close();
            echo "usuario agregado con exito";
            return true; // Usuario agregado con éxito
        } else {
            $stmt->close();
            $conexion->close();
            echo "usuario no agregado";
            return false; // Error al agregar el usuario
        }
    }

    public function Modificar():bool{ //INTERFACE IBM
        $exito = false;
        try{
            $pdo= new PDO("mysql:host=localhost;dbname=usuarios_test","root","");
            $sql=$pdo->prepare("UPDATE usuarios SET nombre=:nombre,correo=:correo,clave=:clave,id_perfil=:id_perfil WHERE id = :id");
           
            $sql->bindParam(':id',$this->id,PDO::PARAM_INT);
            $sql->bindParam(':correo',$this->correo,PDO::PARAM_STR,50);
            $sql->bindParam(':clave',$this->clave,PDO::PARAM_STR,8);
            $sql->bindParam(':nombre',$this->nombre,PDO::PARAM_STR,30);
            $sql->bindParam(':id_perfil',$this->id_perfil,PDO::PARAM_INT,10);
            $sql->execute();
            $exito = true;
        }catch(PDOException $e){
            echo $e->getMessage();
            $exito = false;
        }
        return $exito;
    }

    public static function Eliminar($id) //INTERFACE IBM
    {
        $conexion = new mysqli("localhost","root","","usuarios_test");
        if($conexion->connect_error)
        {
            return false;
        }

        $sql = "DELETE FROM  usuarios WHERE id=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close();
            $conexion->close();
            echo "usuario eliminado con exito";
            return true; 
        } else {
            $stmt->close();
            $conexion->close();
            echo "usuario no agregado";
            return false; 
        }
    }

    public static function TraerTodos(){
        $conexion = new mysqli("localhost","root","","usuarios_test");
        if($conexion->connect_error)
        {
            return false;
        }

        $sql = "SELECT u.correo, u.clave, u.nombre, u.id_perfil, p.descripcion FROM usuarios u JOIN perfiles p ON u.id_perfil = p.id";
        $stmt = $conexion->query($sql);
        $usuarios = [];

        if($stmt->num_rows>0)
        {
            while($row = $stmt->fetch_assoc())
            {
                $usuario = new Usuario();
                $usuario->correo = $row["correo"];
                $usuario->clave = $row["clave"];
                $usuario->nombre = $row["nombre"];
                $usuario->id_perfil = $row["id_perfil"];
                $usuario->perfil = $row["descripcion"];

                $usuarios[] = $usuario;
            }
        }

        $conexion->close();

        return $usuarios;
    }

    public static function TraerUno($params){
        $conexion = new mysqli("localhost","root","","usuarios_test");

        if($conexion->connect_error)
        {
            return false;
        }

        $correo = $params['correo'];
        $clave = $params['clave'];

        $sql = "SELECT u.correo, u.clave, u.nombre, u.id_perfil, p.descripcion FROM usuarios u JOIN perfiles p ON u.id_perfil = p.id WHERE u.correo = ? AND u.clave = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $correo, $clave);
        $stmt->execute();
        $stmt->bind_result($correo,$clave,$nombre, $id_perfil, $perfil);

        if($stmt->fetch())
        {
            $usuario = new Usuario();
            $usuario->correo = $correo;
            $usuario->clave = $clave;
            $usuario->nombre = $nombre;
            $usuario->id_perfil = $id_perfil;
            $usuario->perfil = $perfil;
            $stmt->close();
            $conexion->close();
            echo "se encontro correctamente";
            return $usuario;
        }else{
            $stmt->close();
            $conexion->close();
            echo "se encontro erroneamente";
            return null;
        }
    }
}
?>