<?php

class Eleccion implements IDataBase
{

    private $connection;

    function __construct($directory)
    {
        $this->connection = new DataBaseConnection($directory);
    }

    function getAll()
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Elecciones');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;

        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Elecciones();

                $campo->id_elecciones = $fila->id_elecciones;
                $campo->nombre = $fila->nombre;
                $campo->fecha = $fila->fecha;
                $campo->estado = $fila->estado;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }

    function getEleccionesCandidatos($idElecciones)
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select distinct(id_candidato) FROM Votaciones WHERE id_elecciones = ?');
        $stm->bind_param('i', $idElecciones);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Votaciones();

                $campo->id_candidato = $fila->id_candidato;

                array_push($tabla, $campo); 
            }

            $stm->close();
            return $tabla;
        }
    }

    function getEleccionesPartidos($idElecciones, $idCandidato)
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select distinct(id_partido) FROM Votaciones WHERE id_elecciones = ? and id_candidato = ?');
        $stm->bind_param('ii', $idElecciones, $idCandidato);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Votaciones();

                $campo->id_partido = $fila->id_partido;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }
    function getEleccionesByID($idelecciones)
    {

        $stm = $this->connection->db->prepare('Select count(*) as resultado FROM Votaciones WHERE id_elecciones = ?');
        $stm->bind_param('i', $idelecciones);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return false;
        } else {
            $fila = $resultado->fetch_object();
            $campo = new Votaciones();

            $campo->resultado = $fila->resultado;

            $stm->close();
            return $campo;
        }
    }

    function getEleccionesPuestos($idelecciones, $idcandidato)
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select distinct(id_puesto) FROM Votaciones WHERE id_elecciones = ? and id_candidato = ?');
        $stm->bind_param('ii', $idelecciones, $idcandidato);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Votaciones();

                $campo->id_puesto = $fila->id_puesto;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }

    function getEleccionesPuestosByAll($idElecciones,$cedula,$id_puesto)
    {

        $stm = $this->connection->db->prepare('Select id_puesto, cedula FROM Votaciones WHERE id_elecciones = ? and cedula = ? and id_puesto = ?');
        $stm->bind_param('isi', $idElecciones, $cedula, $id_puesto);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return false;
        } else {

            $fila = $resultado->fetch_object();
            $campo = new Votaciones();

            $campo->id_puesto = $fila->id_puesto;
            $campo->cedula = $fila->cedula;
        
            $stm->close();
            return $campo;
        }
    }


    function MostrarPuesto($cedula,$idElecciones,$listaPuestos) {

        foreach($listaPuestos as $key => $list) {
            $filter = $this->getEleccionesPuestosByAll($idElecciones,$cedula,$list->id_puesto);
            if($filter == true) {
                unset($listaPuestos[$key]);
                array_values($listaPuestos);
            }
        }
        return $listaPuestos;
    }

    function getEleccionesVotoFinal($idElecciones, $idCandidato)
    {

        $stm = $this->connection->db->prepare('Select count(*) as resultado FROM Votaciones WHERE id_elecciones = ? and id_candidato = ? ORDER BY resultado DESC');
        $stm->bind_param('ii', $idElecciones, $idCandidato);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return false;
        } else {
            $fila = $resultado->fetch_object();
            $campo = new Votaciones();

            $campo->resultado = $fila->resultado;

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
        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Elecciones WHERE id_elecciones = ?');
        $stm->bind_param('i', $id);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            $fila = $resultado->fetch_object();
            $campo = new Elecciones();

            $campo->id_elecciones = $fila->id_elecciones;
            $campo->nombre = $fila->nombre;
            $campo->fecha = $fila->fecha;
            $campo->estado = $fila->estado;


            $stm->close();
            return $campo;
        }
    }

    function getByName($name)
    {
        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Elecciones WHERE nombre = ?');
        $stm->bind_param('s', $name);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            $fila = $resultado->fetch_object();
            $campo = new Elecciones();

            $campo->id_elecciones = $fila->id_elecciones;
            $campo->nombre = $fila->nombre;
            $campo->fecha = $fila->fecha;
            $campo->estado = $fila->estado;


            $stm->close();
            return $campo;
        }
    }

    function Add($entity)
    {
        $stm = $this->connection->db->prepare('insert into Elecciones(nombre) VALUES(?)');
        $stm->bind_param('s', $entity);
        $stm->execute();

        $idvoto = $this->connection->db->insert_id;
        header('Location: Iniciar.php?ultimate_id=' . $idvoto);
    }

    function AddResultado($id_elecciones,$id_candidato,$id_partido,$id_puesto,$cedula)
    {
        $stm = $this->connection->db->prepare('insert into Votaciones VALUES(?,?,?,?,?)');
        $stm->bind_param('iiiis', $id_elecciones,$id_candidato,$id_partido,$id_puesto,$cedula);
        $stm->execute();

    }

    function Habilitar($id)
    {
    }

    function Deshabilitar($id)
    {
    }

    function Edit($entity)
    {
    }
}