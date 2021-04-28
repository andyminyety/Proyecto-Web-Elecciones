<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once 'Ciudadanos.php';
require_once '../../Constructor/Ciudadanos.php';

session_start();

$layout = new Layout(true, false);
$datos = new Ciudadano('../../PhpMyAdmin');

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

if(isset($_POST['cedula']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email'])) {
   
    $ciudadanos = new Ciudadanos();
    $ciudadanos->cedula = $_POST['cedula'];
    $ciudadanos->nombre = $_POST['nombre'];
    $ciudadanos->apellido = $_POST['apellido'];
    $ciudadanos->email = $_POST['email'];

    $datos->Add($ciudadanos);

    echo "<script> alert('Ciudadano agregado con éxito.'); </script>";
    
    header('Location: Admin.php');
}

?>
