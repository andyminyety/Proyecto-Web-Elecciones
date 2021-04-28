<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../../PhpMyAdmin/DataBaseConnection.php';
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

if(isset($_GET['id_puesto'])) {

    $idpuesto = $_GET['id_puesto'];
    $puesto = $datos->getById($idpuesto);

    if(isset($_POST['nombre']) && isset($_POST['descripcion'])) {

        if(isset($_GET['id_puesto'])) {
            $idpuesto = $_GET['id_puesto'];

            $puesto = new Puestos();
            $puesto->id_puesto = $idpuesto;
            $puesto->nombre = $_POST['nombre'];
            $puesto->descripcion = $_POST['descripcion'];
    
            $datos->Edit($puesto);
            echo "<lscript> alert('El puesto ha sido añadido correctamente.'); </script>";
    
            header('Location: PuestoElectivo.php');
        }
    }
}

?>

<?php $layout->Header(); ?>

<div class="row margin-top-6">
    <div class="col-md-3"></div>
        <div class="col-md-6 margin-bottom-2">
            <div class="card shadows">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title h4" id="NuevoStudentLabel">Editar Puesto Electivo</h5>
                </div>
                
            <div class="modal-body">
            <form action="Editar.php?id_puesto=<?= $idpuesto; ?>" method="POST">
            
                <div class="mb-3">
                    <label for="nombrepuesto" class="form-label">Nombre del puesto</label>
                    <input name="nombre" value="<?= $puesto->nombre; ?>"class="form-control" id="nombrepuesto" placeholder="Ingrese el nuevo nombre del puesto">
                </div>

                <div class="mb-3">
                    <label for="descripcionpuesto" class="form-label">Descripcion</label>
                    <input name="descripcion" value="<?= $puesto->descripcion; ?>"class="form-control" id="descripcionpuesto" placeholder="Ingrese una descripción del puesto">
                </div>

                <div style="margin-left: 69.5%;">
                    <a href="PuestoElectivo.php" class="btn btn-danger float-end">Volver</a>
                    <button type="submit" class="btn btn-dark float-end">Editar</button>
                </div>
            </form>
            </div>
            </div>
        </div>
    </div>
</div>

<?php $layout->Footer(); ?>