<?php

require_once '../../PhpMyAdmin/databaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase.php';

class Ciudadano implements IDataBase
{

    private $connection;

    function __construct($directory)
    {
        $this->connection = new databaseConnection($directory);
    }

    function getAll()
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Ciudadanos');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Ciudadanos();

                $campo->cedula = $fila->cedula;
                $campo->nombre = $fila->nombre;
                $campo->apellido = $fila->apellido;
                $campo->email = $fila->email;
                $campo->estado = $fila->estado;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }

    function getCiudadanoByCedula($cedula)
    {

        $stm = $this->connection->db->prepare('Select * FROM Ciudadanos where cedula = ?');
        $stm->bind_param("s",$cedula);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

        } else {
                $fila = $resultado->fetch_object();
                $campo = new Ciudadanos();

                $campo->cedula = $fila->cedula;
                $campo->nombre = $fila->nombre;
                $campo->apellido = $fila->apellido;
                $campo->email = $fila->email;
                $campo->estado = $fila->estado;

                
            

            $stm->close();
            return $campo;
        }
    }

    function getActive()
    {
    }

    function getInactive()
    {
    }

    function getById($id)
    {
        $stm = $this->connection->db->prepare('Select * FROM Ciudadanos where cedula = ?');
        $stm->bind_param('i', $id);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return null;
        } else {

            $fila = $resultado->fetch_object();
            $campo = new Ciudadanos();

            $campo->cedula = $fila->cedula;
            $campo->nombre = $fila->nombre;
            $campo->apellido = $fila->apellido;
            $campo->email = $fila->email;
            $campo->estado = $fila->estado;

            $stm->close();
            return $campo;
        }
    }

    function Add($entity)
    {
        $stm = $this->connection->db->prepare('insert into Ciudadanos(cedula,nombre,apellido,email) VALUES(?,?,?,?)');
        $stm->bind_param('ssss', $entity->cedula, $entity->nombre, $entity->apellido, $entity->email);
        $stm->execute();
    }
    
    function CandidatoGenerico($id)
    {
    }

    function Habilitar($id)
    {
        $stm = $this->connection->db->prepare('update Ciudadanos set estado = true where cedula = ?');
        $stm->bind_param('s', $id);
        $stm->execute();
    }

    function Deshabilitar($id)
    {
        $stm = $this->connection->db->prepare('update Ciudadanos set estado = false where cedula = ?');
        $stm->bind_param('s', $id);
        $stm->execute();
    }

    function Edit($entity)
    {
        $stm = $this->connection->db->prepare('update Ciudadanos set nombre = ?, apellido = ?, email = ? where cedula = ?');
        $stm->bind_param('ssss', $entity->nombre, $entity->apellido, $entity->email, $entity->cedula);
        $stm->execute();
    }
}
