<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once 'Administracion.php';
require_once '../../PhpMyAdmin/IDatabase.php';
require_once '../../PhpMyAdmin/IDataBase2.php';
require_once '../PuestoElectivo/Puesto.php';
require_once '../../Constructor/Puestos.php';

session_start();

if(isset($_SESSION['ciudadano'])) {
    header('Location: ../../index.php');
}

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: Login.php');
}

$layout = new Layout(true, false);
$datos = new Administracion('../../PhpMyAdmin');
$datospuestos = new Puesto('../../PhpMyAdmin');
$puestos = $datospuestos->getActive();

?>

<?php $layout->Header(); ?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h2 class="text-center margin-top-6"><strong>Bienvenido Administrador</strong></h2>
        <p class="text-center">Seleccione una de las opciones para seguir con el sistema de elecciones.</p>
        <div class="text-center"><img src="../../assets/Img/Almacenamiento/votar2.png" class="icon" alt="User Icon"></div>
    </div>
    <div class="col-md-6">
</div>

<?php $layout->Footer(); ?>