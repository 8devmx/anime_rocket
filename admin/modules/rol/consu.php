<?php

class modules extends mysqli
{
    public function __construct($host, $usuario, $pass, $bd)
    {
        $this->conexion= new mysqli("localhost", "root", "", "anime_rocket");
    }

    public function get_data()
    {
        $consulta = "SELECT * FROM rel_rol";
        $result = $this->conexion->query($consulta);
        $array = [];
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $array[] = [
                "rol"=> $row["rol"],
            ];
        }
        echo json_encode($array);
    }
    public function get_one($id)
    {
        $consulta = "SELECT * FROM rel_rol  WHERE id = $id";
        $result = $this->conexion->query($consulta);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $array = [
        
                "rol"=> $row["rol"],
        ];
        echo json_encode($array);
    }

    public function insert_data()
    {
        mysqli_report(MYSQLI_REPORT_OFF);
        $rol = $_POST['rol'];
        $consulta = "INSERT INTO rel_rol ( rol) VALUES ( '$rol')";
        $result = $this->conexion->query($consulta);
        if ($result) {
            $array = [
            "status" => "success",
            "text" => "Se insertó correctamente"
        ];
        }else{
            $array = [
                "status" => "error",
                "text" => "No se pudo insertar el registro"
            ];
        }
        echo json_encode($array);
    }
    
    public function update_data()
    {
        mysqli_report(MYSQLI_REPORT_OFF);
   
        $rol = $_POST['rol'];
        $id = $_POST['id'];

        $consulta = "UPDATE rel_rol set rol = '$rol' WHERE id =  $id";
        $this->conexion->query($consulta);
        $array = [
            "status" => "success",
            "text" => "Se editó correctamente"
        ];

        if (!$this->conexion->affected_rows>0) {
            $array = [
                "status" => "error",
                "text" => "No se pudo insertar el registro"
            ];
        }
        echo json_encode($array);
    }
    public function delete_data()
    {
        $datos = $_POST["data"];
        $consulta = "DELETE FROM rel_rol WHERE id IN ($datos)";
        $this->conexion->query($consulta);
        $array = [
            "text" => "Se eliminó correctamente",
            "status" => "success",
        ];
        echo json_encode($array);
    }
}

$modules = new modules("localhost", "root", "", "anime_rocket");

if (isset($_POST)) {
    switch ($_POST["funcion"]) {
        case 'get_data':
            $modules->get_data();
            break;
        case 'get_one':
            $modules->get_one($_POST['id']);
            break;
        case 'insert_data':
            $modules->insert_data();
            break;
        case 'update_data':
            $modules->update_data($_POST['id']);
            break;
        case 'delete_data':
            $modules->delete_data();
            break;
        default:
            echo "Función incompleta";
            break;
    }
}
