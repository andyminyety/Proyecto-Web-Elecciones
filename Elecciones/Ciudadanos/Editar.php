<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once 'Ciudadanos.php';
require_once '../../Constructor/Ciudadanos.php';

session_start();

$layout = new Layout(true, false);
$datos  = new Ciudadano('../../PhpMyAdmin');

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

if(isset($_GET['cedula'])) {

    $cedula = $_GET['cedula'];
    $puestos = $datos->getById($cedula);

    if( isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email'])) {

        if(isset($_GET['cedula'])) {
            $cedula = $_GET['cedula'];
            
            $ciudadano = new Ciudadanos();
            $ciudadano->cedula = $cedula;
            $ciudadano->nombre = $_POST['nombre'];
            $ciudadano->apellido = $_POST['apellido'];
            $ciudadano->email = $_POST['email'];
    
            $datos->Edit($ciudadano);
            
    
            header('Location:  Admin.php');
      
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
                    <h5 class="modal-title h4" id="NuevoStudentLabel">Editar Ciudadano</h5>
                </div>
                
                <div class="modal-body">
                <form  action="Editar.php?cedula=<?= $cedula; ?>" method="POST">

                    <div class="mb-3">
                        <label for="nombreciudadano">Nombre del Ciudadano</label>
                        <input value="<?= $puestos->nombre; ?>" class="form-control" id="nombreciudadano" name='nombre'>
                    </div>

                    <div class="mb-3">
                        <label for="apellidociudadano">Apellido del Candidato</label>
                        <input value="<?= $puestos->apellido; ?>"class="form-control" id="apellidociudadano" name='apellido'>
                    </div>
                    
                    <div class="mb-3">
                        <label for="emailciudadano">Correo electrónico</label>
                        <input type="email" value="<?= $puestos->email; ?>" class="form-control" id="emailciudadano" name='email'>
                    </div>

                    <div style="margin-left: 69.5%;">
                        <a href="Admin.php" class="btn btn-danger float-end">Volver</a>
                        <button type="submit" class="btn btn-dark float-end">Editar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $layout->Footer(); ?>
