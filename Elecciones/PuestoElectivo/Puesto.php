<?php

class Puesto implements IDataBase
{

    private $connection;

    function __construct($directory)
    {
        $this->connection = new DataBaseConnection($directory);
    }

    function getAll()
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Puestos');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Puestos();

                $campo->id_puesto = $fila->id_puesto;
                $campo->nombre = $fila->nombre;
                $campo->descripcion = $fila->descripcion;
                $campo->estado = $fila->estado;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }

    function getActive()
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Puestos WHERE estado = true');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Puestos();

                $campo->id_puesto = $fila->id_puesto;
                $campo->nombre = $fila->nombre;
                $campo->descripcion = $fila->descripcion;
                $campo->estado = $fila->estado;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }

    function getInactive()
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Puestos WHERE estado = false');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Puestos();

                $campo->id_puesto = $fila->id_puesto;
                $campo->nombre = $fila->nombre;
                $campo->descripcion = $fila->descripcion;
                $campo->estado = $fila->estado;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }

    function getById($id)
    {
        $stm = $this->connection->db->prepare('Select * FROM Puestos where id_puesto = ?');
        $stm->bind_param('i', $id);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return null;
        } else {

            $fila = $resultado->fetch_object();
            $campo = new Puestos();

            $campo->id_puesto = $fila->id_puesto;
            $campo->nombre = $fila->nombre;
            $campo->descripcion = $fila->descripcion;
            $campo->estado = $fila->estado;

            $stm->close();
            return $campo;
        }
    }

    function Add($entity)
    {
        $stm = $this->connection->db->prepare('insert into Puestos(nombre,descripcion) VALUES(?,?)');
        $stm->bind_param('ss', $entity->nombre, $entity->descripcion);
        $stm->execute();
    }

    function Habilitar($id)
    {
        $stm = $this->connection->db->prepare('update Puestos set estado = true where id_puesto = ?');
        $stm->bind_param('i', $id);
        $stm->execute();
    }

    function Deshabilitar($id)
    {
        $stm = $this->connection->db->prepare('update Puestos set estado = false where id_puesto = ?');
        $stm->bind_param('i', $id);
        $stm->execute();
    }

    function Edit($entity)
    {
        $stm = $this->connection->db->prepare('update Puestos set nombre = ?, descripcion = ? where id_puesto = ?');
        $stm->bind_param('ssi', $entity->nombre, $entity->descripcion, $entity->id_puesto);
        $stm->execute();
    }

}
