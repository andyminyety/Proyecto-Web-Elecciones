<?php 

require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase2.php';

class Administracion implements IDataBase2 {

    private $connection;

    function __construct($directory)
    {
        $this->connection = new DataBaseConnection($directory);
    }

    function getById($id) {

    }

    function Add($entity) {

    }
    
    function Deshabilitar($id) {

    }

    public function getAdministrador($campo, $clave)
    {

        $stm = $this->connection->db->prepare('Select * FROM administracion where usuario = ? and clave = ?');
        $stm->bind_param('ss', $campo, $clave);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return null;
        } else {

            $fila = $resultado->fetch_object();
            $campo = new Administrador();

            $campo->id_usuario = $fila->id_usuario;
            $campo->usuario = $fila->usuario;
            $campo->clave = $fila->clave;
            $campo->nombre = $fila->nombre;
            $campo->apellido = $fila->apellido;
            $campo->cedula = $fila->cedula;

            $stm->close();
            return $campo;
        }
    }

    public function getAdministradorById($id)
    {

        $stm = $this->connection->db->prepare('Select * FROM administracion where id_usuario = ?');
        $stm->bind_param('i', $id);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return null;
        } else {

            $fila = $resultado->fetch_object();
            $campo = new Administrador();

            $campo->id_usuario = $fila->id_usuario;
            $campo->usuario = $fila->usuario;
            $campo->clave = $fila->clave;
            $campo->nombre = $fila->nombre;
            $campo->apellido = $fila->apellido;
            $campo->cedula = $fila->cedula;

            $stm->close();
            return $campo;
        }
    }
}

?>