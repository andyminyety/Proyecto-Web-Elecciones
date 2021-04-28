<?php

require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once 'Candidatos.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../Constructor/Candidatos.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

$servicio = new Candidato('../../PhpMyAdmin');

if(isset($_GET['id'])) {
    
    $idcandidato = $_GET['id'];

    $id = $servicio->GetById($_GET["id"]);

    $servicio->Deshabilitar($id->id_candidato);

    header("Location: ListarCandidatos.php");
}


?>