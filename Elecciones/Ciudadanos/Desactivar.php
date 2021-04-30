<?php 

require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDatabase.php';
require_once '../Ciudadanos/Ciudadanos.php';

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
    $datos = new Ciudadano('../../PhpMyAdmin');

    if(isset($_GET['cedula'])) {
    
        $cedula = $_GET['cedula'];
    
        $datos->Deshabilitar($cedula);
    
        header('Location: Admin.php');
    }
}


?>