<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../Partidos/Partidos.php';
require_once '../../Constructor/Puestos.php';
require_once '../../Constructor/Partidos.php';

session_start();

$layout = new Layout(true, false);
$datos = new Partido('../../PhpMyAdmin');

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

if(isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_FILES['logo'])) {
    
    $partido = new Partidos();
    $partido->nombre = $_POST['nombre'];
    $partido->descripcion = $_POST['descripcion'];

    $datos->Add($partido);
    echo "<script> alert('El puesto ha sido añadido correctamente.'); </script>";

    header('Location: Admin.php');
}

?>

