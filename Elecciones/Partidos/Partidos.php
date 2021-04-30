<?php

require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase.php';

class Partido implements IDataBase
{

    private $connection;

    function __construct($directory)
    {
        $this->connection = new DataBaseConnection($directory);
    }

    function getAll()
    {

        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Partidos');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Partidos();

                $campo->id_partido = $fila->id_partido;
                $campo->nombre = $fila->nombre;
                $campo->descripcion = $fila->descripcion;
                $campo->logo = $fila->logo;
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

        $stm = $this->connection->db->prepare('Select * FROM Partidos WHERE estado = true');
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            while ($fila = $resultado->fetch_object()) {
                $campo = new Partidos();

                $campo->id_partido = $fila->id_partido;
                $campo->nombre = $fila->nombre;
                $campo->descripcion = $fila->descripcion;
                $campo->logo = $fila->logo;
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

    function getById($id)
    {
        $tabla = array();

        $stm = $this->connection->db->prepare('Select * FROM Partidos where id_partido = ?');
        $stm->bind_param('i', $id);
        $stm->execute();

        $resultado = $stm->get_result();

        if ($resultado->num_rows === 0) {

            return $tabla;
        } else {
            $fila = $resultado->fetch_object(); 
            $campo = new Partidos();

            $campo->id_partido = $fila->id_partido;
            $campo->nombre = $fila->nombre;
            $campo->descripcion = $fila->descripcion;
            $campo->logo = $fila->logo;
            $campo->estado = $fila->estado;
            
            $stm->close();
            return $campo;
        }
    }

    function Add($entity)
    {

        if (isset($_FILES['logo'])) {
            $logo = $_FILES['logo'];

            if ($logo['error'] == 4) {
                $entity->logo = "";
            } else {

                $typeReplace = str_replace("image/", "", $_FILES['logo']['type']);
                $type = $logo['type'];
                $size = $logo['size'];
                $name = $entity->nombre . '.' . $typeReplace;
                $timeFile = $logo['tmp_name'];

                $sucess = $this->uploadImage('../../assets/Img/partidos/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity->logo = $name;
                }
            }
        }

        $stm = $this->connection->db->prepare('insert into Partidos(nombre,descripcion,logo) VALUES(?,?,?)');
        $stm->bind_param('sss', $entity->nombre, $entity->descripcion, $entity->logo);
        $stm->execute();
    }

    function Habilitar($id)
    {
        $stm = $this->connection->db->prepare('update Partidos set estado = true where id_partido = ?');
        $stm->bind_param('i', $id);
        $stm->execute();

        $stm = $this->connection->db->prepare('update Candidatos set estado = true where id_partido = ?');
        $stm->bind_param('i', $id);
        $stm->execute();
    }
    function candidatoGenerico($id)
    {
    }

    function Deshabilitar($id)
    {
        $stm = $this->connection->db->prepare('update Partidos set estado = false where id_partido = ?');
        $stm->bind_param('i', $id);
        $stm->execute();

        $stm = $this->connection->db->prepare('update Candidatos set estado = false where id_partido = ?');
        $stm->bind_param('i', $id);
        $stm->execute();
    }

    function Edit($entity)
    {

        if (isset($_FILES['logo'])) {
            $logo = $_FILES['logo'];

            if ($logo['error'] == 4) {
                $entity->logo = "";
            } else {

                $typeReplace = str_replace("image/", "", $_FILES['logo']['type']);
                $type = $logo['type'];
                $size = $logo['size'];
                $name = $entity->nombre . '.' . $typeReplace;
                $timeFile = $logo['tmp_name'];

                $sucess = $this->uploadImage('../../assets/Img/Partidos/', $name, $timeFile, $type, $size);

                if ($sucess) {

                    $entity->logo = $name;
                }
            }
        }

        $stm = $this->connection->db->prepare('update partidos set nombre = ?, descripcion = ?, logo = ? where id_partido = ?');
        $stm->bind_param('sssi', $entity->nombre, $entity->descripcion, $entity->logo, $entity->id_partido);
        $stm->execute();
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
