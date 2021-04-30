<?php

require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase.php';

class Candidato implements IDataBase
{

    private $connection;

    function __construct($directory)
    {
        $this->connection = new DataBaseConnection($directory);
    }

    function getActiveAll()
    {
        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Candidatos where estado = true');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Candidatos();

                $campo->id_candidato = $fila->id_candidato;
                $campo->nombre = $fila->nombre;
                $campo->apellido = $fila->apellido;
                $campo->id_partido = $fila->id_partido;
                $campo->id_puesto = $fila->id_puesto;
                $campo->foto = $fila->foto;
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

        $stm = $this->connection->db->prepare('Select * FROM Candidatos');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Candidatos();

                $campo->id_candidato = $fila->id_candidato;
                $campo->nombre = $fila->nombre;
                $campo->apellido = $fila->apellido;
                $campo->id_partido = $fila->id_partido;
                $campo->id_puesto = $fila->id_puesto;
                $campo->foto = $fila->foto;
                $campo->estado = $fila->estado;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }

    function getInactive()
    {
    }

    function getCandidatoByPuesto($idpuesto)
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Candidatos where id_puesto = ?');
        $stm->bind_param('i', $idpuesto);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Candidatos();

                $campo->id_candidato = $fila->id_candidato;
                $campo->nombre = $fila->nombre;
                $campo->apellido = $fila->apellido;
                $campo->id_partido = $fila->id_partido;
                $campo->id_puesto = $fila->id_puesto;
                $campo->foto = $fila->foto;
                $campo->estado = $fila->estado;

                array_push($tabla, $campo);
            }

            $stm->close();
            return $tabla;
        }
    }

    function getById($id)
    {
        $stm = $this->connection->db->prepare('Select * FROM Candidatos where id_candidato = ?');
        $stm->bind_param('i', $id);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return null;
        } else {

            $fila  = $resultado->fetch_object();
            $campo = new Candidatos();

            $campo->id_candidato = $fila->id_candidato;
            $campo->nombre = $fila->nombre;
            $campo->apellido = $fila->apellido;
            $campo->id_partido = $fila->id_partido;
            $campo->id_puesto = $fila->id_puesto;
            $campo->foto = $fila->foto;
            $campo->estado = $fila->estado;

            $stm->close();
            return $campo;
        }
    }

    function Add($entity)
    {
        if (isset($_FILES['foto'])) {
            $foto = $_FILES['foto'];

            if ($foto['error'] == 4) {
                $entity->foto = "";
            } else {

                $typeReplace = str_replace("image/", "", $_FILES['foto']['type']);
                $type        = $foto['type'];
                $size        = $foto['size'];
                $name        = $entity->nombre . ' ' . $entity->apellido . '.' . $typeReplace;
                $timeFile    = $foto['tmp_name'];

                $sucess = $this->uploadImage('../../assets/Img/Candidatos/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity->foto = $name;
                }
            }
        }

        $stm = $this->connection->db->prepare('insert into Candidatos (nombre, apellido, id_partido, id_puesto, foto, estado) Values(?, ?, ?, ?, ?, ?)');
        $stm->bind_param('ssiisi', $entity->nombre, $entity->apellido, $entity->id_partido, $entity->id_puesto, $entity->foto, $entity->estado);
        $stm->execute();
        $stm->close();
    }

    function Habilitar($id)
    {
        $stm = $this->connection->db->prepare("update Candidatos set estado = 1 where id_candidato=?");
        $stm->bind_param("i", $id);
        $stm->execute();
        $stm->close();
    }

    function Deshabilitar($id)
    {
        $stm = $this->connection->db->prepare("update Candidatos set estado = 0 where id_candidato=?");
        $stm->bind_param("i", $id);
        $stm->execute();
        $stm->close();
    }
    function CandidatoGenerico($id)
    {
        $stm = $this->connection->db->prepare('insert into Candidatos( nombre, apellido, id_partido, id_puesto, foto, estado) VALUES ("Voto","Nulo",1,1,"Genérico.jpeg",1);');
        $stm->bind_param('i', $id);
        $stm->execute();
    }

    function Edit($entity)
    {
        if (isset($entity->foto)) {
            $foto = [];
            $foto = $entity->foto;

            if ($foto['error'] == 4) {
                $entity->foto = "";
            } else {

                $typeReplace = str_replace("image/", "", $_FILES['foto']['type']);
                $type        = $foto['type'];
                $size        = $foto['size'];
                $name        = $entity->nombre . ' ' . $entity->apellido . '.' . $typeReplace;
                $timeFile    = $foto['tmp_name'];

                $sucess = $this->uploadImage('../../assets/Img/Candidatos/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity->foto = $name;
                }
            }
        }

        $stm = $this->connection->db->prepare('update Candidatos set nombre = ?, apellido = ?, id_partido = ?, id_puesto = ?, foto = ?, estado = ? where id_candidato = ?');
        var_dump($entity);
        $stm->bind_param('ssiisii', $entity->nombre, $entity->apellido, $entity->id_partido, $entity->id_puesto, $entity->foto, $entity->estado, $entity->id_candidato);
        $stm->execute();
        $stm->close();
    }

    private function uploadFile($name, $timeFile)
    {

        if (file_exists($name)) {

            unlink($name);
        }

        move_uploaded_file($timeFile, $name);
    }

    public function uploadImage($directory, $name, $timeFile, $type, $size)
    {

        $isSucess = false;
        if (($type == "image/gif")
            || ($type == "image/jpeg")
            || ($type == "image/png")
            || ($type == "image/jpg")
            || ($type == "image/JPG")
            || ($type == "image/jfif")
            || ($type == "image/pjpeg") && ($size < 1000000)
        ) {


            if (!file_exists($directory)) {

                mkdir($directory, 0777, true);

                if (file_exists($directory)) {

                    $this->uploadFile($directory . $name, $timeFile);
                    $isSucess = true;
                }
            } else {

                $this->uploadFile($directory . $name, $timeFile);
                $isSucess = true;
            }
        } else {

            $isSucess = false;
        }

        return $isSucess;
    }
}
