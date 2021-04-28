<?php
require_once 'Layouts/Layout.php';
require_once 'Helpers/File/JsonFile.php';
require_once 'PhpMyAdmin/DataBaseConnection.php';
require_once 'PhpMyAdmin/IDatabase.php';
require_once 'Elecciones/PuestoElectivo/Puesto.php';
require_once 'Elecciones/Elecciones/Elecciones.php';
require_once 'Constructor/Puestos.php';
require_once 'Constructor/Votaciones.php';

session_start();

if (!isset($_SESSION['elecciones'])) {

    echo "<script alert('No hay elecciones activa.')</script>";
}
 
if (isset($_SESSION['administracion'])) {

    header('Location: Elecciones/Login/Admin.php');
}

if (isset($_SESSION['elecciones']) && isset($_SESSION['ciudadano'])) {

    $elecciones = json_decode($_SESSION['elecciones']);
    $ciudadano = json_decode($_SESSION['ciudadano']);

} else {

    header('Location: Electores/login/Login.php');
}

$layout = new Layout(false, true);
$datospuestos = new Puesto('PhpMyAdmin');
$verificacion = new Eleccion('PhpMyAdmin');
$datosfinales = $datospuestos->getAll();
$puestos = $verificacion->MostrarPuesto($ciudadano->cedula,$elecciones->id_elecciones,$datosfinales);

?>

<?php $layout->Header(); ?>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"></div>   
    <div class="col-md-8"></div>
</div>

<div class="row margin-top-4">
    <?php if ($puestos == "" || $puestos == null ) : ?>

    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h2 class="text-center margin-top-2"><strong>Ya has votado por los puestos disponibles</strong></h2>
        <p class="text-center">Por favor cerrar la sesión.</p>
        <div class="text-center"><img src="assets/Img/Almacenamiento/no disponible.png" class="icon" alt="User Icon"></div>
    </div>
    <div class="col-md-6"></div>

<?php  elseif  ($puestos == "" || $puestos == null || $ciudadano->estado == 0) : ?>

    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h2 class="text-center margin-top-2"><strong>Este ciudadano esta inactivo</strong></h2>
        <p class="text-center">Por favor cerrar la sesión.</p>
        <div class="text-center"><img src="assets/Img/Almacenamiento/no disponible.png" class="icon" alt="User Icon"></div>
    </div>
    <div class="col-md-6"></div>

    <?php else : ?>
        <?php foreach ($puestos as $puesto) : ?>

            <div class="col-md-4 margin-bottom-4">
                <div class="card shadows">
                    <div class="modal-header text-white bg-dark">
                        <h5 class="modal-title h4" id="NuevoStudentLabel">Elecciones - <?= $puesto->nombre; ?></h5>
                    </div>
                    <div class="card-body">
                        <h5>Información</h5>
                        <p class="card-title"><?= $puesto->descripcion; ?></p>

                        <a href="Electores\login\Votacion.php?id_puesto=<?= $puesto->id_puesto; ?>" class="btn btn-danger">Ver candidatos</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php $layout->Footer(); ?>