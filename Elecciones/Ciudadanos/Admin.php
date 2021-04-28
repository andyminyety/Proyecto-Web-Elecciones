<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../Ciudadanos/Ciudadanos.php';
require_once '../../Constructor/Ciudadanos.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

$layout = new Layout(true, false);
$datosciudadanos = new Ciudadano('../../PhpMyAdmin');
$puestosciudadanos = $datosciudadanos->getAll();

?>

<?php $layout->Header(); ?>

<div class="row">
    <div class="col-md-10"></div>
    <a class="btn btn-dark margin-top-1" data-bs-toggle="modal" data-bs-target="#elecciones">
        Agregar Ciudadano</a>
    </div>
</div>

<div class="row margin-top-2">
<?php if ($puestosciudadanos == "" || $puestosciudadanos == null) : ?>
        <div class="col-md-4">
            <h2>No hay ciudadanos agregados.</h2>
        </div>

    <?php else : ?>
        <?php foreach ($puestosciudadanos as $puestos) : ?>
            <div class="col-md-4 margin-bottom-4">
                <div class="card shadows">
                    <div class="modal-header text-white bg-dark">
                        <h5 class="modal-title h4" id="NuevoStudentLabel">Ciudadano</h5>
                    </div>
                
                    <img class="bd-placeholder-img card-img-top" src="<?= "../../assets/Img/Almacenamiento/default.jpeg"  ?>" width="100%" height="235" aria-label="Placeholder: Thumbnail">
        
                    <div class="card-body">
                        <h5>Nombre</h5>
                        <p class="card-title"><?= $puestos->nombre; ?> <?= $puestos->apellido; ?></p>
                        <h5>Cédula</h5>
                        <p class="card-text"><?= $puestos->cedula; ?></p>
                        <h5>Email</h5>
                        <p class="card-text"><?= $puestos->email; ?></p>
                    
                        <a href="Editar.php?cedula=<?= $puestos->cedula; ?>" style="margin-left: 35%;" class="btn btn-dark">Editar</a>

                        <?php if ($puestos->estado == 1) : ?> 
                            <a class="btn btn-danger float-end" href="Desactivar.php?cedula=<?= $puestos->cedula; ?>">Desactivar</a>
                        <?php else : ?>
                            <a class="btn btn-success float-end" href="Activar.php?cedula=<?= $puestos->cedula; ?>">Activar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<div class="modal fade" id="elecciones" tabindex="-1" aria-labelledby="Elecciones" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content margin-top-20">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="Elecciones">Nuevo Ciudadano</h5>
            </div>

        <div class="modal-body">
        <form  action='Agregar.php' method="POST">

            <div class="mb-3">
                <label for="nombreciudadano">Nombre del Ciudadano</label>
                <input class="form-control" id="nombreciudadano" required name='nombre'>
            </div>

            <div class="mb-3">
                <label for="apellidociudadano">Apellido del Candidato</label>
                <input class="form-control" id="apellidociudadano" required name='apellido'>
            </div>

            <div class="mb-3"> 
                <label for="cedulaciudadano">Cédula</label>
                <input class="form-control" id="cedulaciudadano" required name='cedula'>
            </div>

            <div class="mb-3">
                <label for="apellidocandidato">Correo electrónico</label>
                <input type="email" class="form-control" id="emailciudadano" required name='email'>
            </div>

            <div style="margin-left: 63%;">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-dark float-end" type="submit">Agregar</button>
            </div>
        </form>
        </div>
        </div>
    </div>
</div>

<?php $layout->Footer(); ?>