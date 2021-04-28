<?php 

require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../PuestoElectivo/Puesto.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

$datos = new Puesto('../../PhpMyAdmin');

if(isset($_GET['id_puesto'])) {

    $idpuesto = $_GET['id_puesto'];

    $datos->Deshabilitar($idpuesto);

    header('Location: PuestoElectivo.php');
}

?>