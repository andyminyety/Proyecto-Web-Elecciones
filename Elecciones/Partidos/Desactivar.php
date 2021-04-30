<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once 'Partidos.php';
require_once '../../Constructor/Puestos.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

$elecciones = json_decode($_SESSION['elecciones']);
if ($elecciones->estado == 1){
    header('Location: Admin.php');
}else{
    $datos = new Partido('../../PhpMyAdmin');

if(isset($_GET['id_partido'])) {

    $idpartido = $_GET['id_partido'];

    $datos->Deshabilitar($idpartido);

    header('Location: Admin.php');
}

}



?>
