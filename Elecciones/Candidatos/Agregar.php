<?php

    require_once '../../Layouts/Layout.php';
    require_once '../../Helpers/File/JsonFile.php';
    require_once '../../PhpMyAdmin/IDataBase.php';
    require_once '../Partidos/Partidos.php';
    require_once '../PuestoElectivo/Puesto.php';
    require_once '../../Constructor/Puestos.php';
    require_once '../../Constructor/Partidos.php';
    require_once '../../Constructor/Candidatos.php';
    require_once 'Candidatos.php';

    session_start();
    
    $servicio = new Candidato('../../PhpMyAdmin');

    if (isset($_SESSION['administracion'])) {
        $admin = json_decode($_SESSION['administracion']);
    } else {
        header('Location: ../../Login/Login.php');
    }

    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['id_partido']) && isset($_POST['id_puesto']) && isset($_FILES['foto'])) {
        
        $candidatos = new Candidatos();
        $candidatos->InizializeData(0, $_POST['nombre'], $_POST['apellido'], $_POST['id_partido'], $_POST['id_puesto'], $_FILES['foto'], 1);

        $servicio->Add($candidatos);
        
        header("Location: ListarCandidatos.php");
        exit();
    
    }
?>