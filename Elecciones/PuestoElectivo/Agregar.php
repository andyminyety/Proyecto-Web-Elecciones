<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../PuestoElectivo/Puesto.php';
require_once '../../Constructor/Puestos.php';

session_start();

$layout = new Layout(true, false);
$datos = new Puesto('../../PhpMyAdmin');


if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

if(isset($_POST['nombre']) && isset($_POST['descripcion'])) {
    
    $puesto = new Puestos();
    $puesto->nombre = $_POST['nombre'];
    $puesto->descripcion = $_POST['descripcion'];

    $datos->add($puesto);
    $id = $_GET['id_puesto'];
    $datos->candidatoGenerico($id);
    echo "<script> alert('El puesto ha sido añadido correctamente.'); </script>";

    header('Location: PuestoElectivo.php');
}
?>
