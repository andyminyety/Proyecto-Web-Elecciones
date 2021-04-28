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

if (isset($_GET['id_partido'])) {

    $idpartido = $_GET['id_partido'];

    $partido = $datos->GetById($idpartido);

    if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_FILES['logo'])) {

        if (isset($_GET['id_partido'])) {

            $idpartido = $_GET['id_partido'];

            $partido = new Partidos();
            $partido->id_partido = $idpartido;
            $partido->nombre = $_POST['nombre'];
            $partido->descripcion = $_POST['descripcion'];
;
            $datos->Edit($partido);
            echo "<script> alert('El puesto ha sido modificado correctamente.'); </script>";

            header('Location: Admin.php');
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
                <form enctype="multipart/form-data" action='Editar.php?id_partido=<?= $idpartido; ?>' method="POST">
                    
                    <div class="mb-3">
                        <label for="nombrepartido">Nombre del partido</label>
                        <input class="form-control" id="nombrepartido" placeholder="Ingrese el nombre del nuevo puesto" value="<?= $partido->nombre; ?>" name='nombre'>
                    </div>

                    <div class="mb-3">
                        <label for="descripcionpartido">Descripción del partido</label>
                        <input class="form-control" id="descripcionpartido" placeholder="Ingrese una descripción del puesto" value="<?= $partido->descripcion; ?>" name='descripcion'>
                    </div>

                    <div class="mb-3">
                        <label for="logo">Logo</label>
                        <input type="file" class="form-control" name="logo" id="logo">
                    </div>

                    <div style="margin-left: 69.5%;">
                        <a href="Admin.php" class="btn btn-danger float-end">Volver</a>
                        <button class="btn btn-dark float-end" type="submit">Editar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $layout->Footer(); ?>