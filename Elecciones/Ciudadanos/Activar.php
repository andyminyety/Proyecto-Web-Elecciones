<?php

require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../Ciudadanos/Ciudadanos.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

$datos = new Ciudadano('../../PhpMyAdmin');

if(isset($_GET['cedula'])) {

    $cedula = $_GET['cedula'];

    $datos->Habilitar($cedula);

    header('Location: Admin.php');
}

?>