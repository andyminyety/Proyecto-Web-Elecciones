<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once 'Partidos.php';
require_once '../../Constructor/Partidos.php';

session_start();
if (isset($_SESSION['elecciones'])) {

    $Elecciones = json_decode($_SESSION['elecciones']);
}
if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

$layout = new Layout(true, false);
$datospartidos = new Partido('../../PhpMyAdmin');
$partidos = $datospartidos->getAll();

?>
<?php $layout->Header(); ?>

<div class="row">
    <div class="col-md-10"></div>
    <a class="btn btn-dark margin-top-1 margin-bottom-2" data-bs-toggle="modal" data-bs-target="#elecciones">
        Agregar Partido</a>
    <div class="col-md-8"></div>
</div>


<div class="row">
    <?php if ($partidos == "" || $partidos == null) : ?>

        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="text-center margin-top-2"><strong>No hay partidos agregados</strong></h2>
            <p class="text-center">Por favor agregar uno.</p>
        <div class="text-center"><img src="../../assets/Img/Almacenamiento/no disponible.png" class="icon" alt="User Icon"></div>
        <div class="col-md-6"></div>
    
    <?php else : ?>
        <?php foreach ($partidos as $partido) : ?>
            <?php if ( $partido->nombre == "Nulo") : ?>

            <?php else : ?>

            <div class="margin-top-2"></div>
            <div class="col-md-3 margin-bottom-4">
            <div class="card shadows">
  
                <img class="bd-placeholder-img card-img-top" src="../../assets/Img/Partidos/<?= $partido->logo; ?>" width="200" height="250" aria-label="Placeholder: Thumbnail">
        
                 <div class="card-body">
                    <h5><strong class="card-title"><?= $partido->nombre; ?></strong></h5>
                    <p class="card-text"><?= $partido->descripcion; ?></p>
                
                    <a href="Editar.php?id_partido=<?= $partido->id_partido; ?>" class="btn btn-dark">Editar</a>
                    <?php if ($partido->estado == 1) : ?>
                    <a href="Desactivar.php?id_partido=<?= $partido->id_partido; ?>" class="btn btn-danger">Desactivar</a>
                    <?php else : ?>
                    <a href="Activar.php?id_partido=<?= $partido->id_partido; ?>" class="btn btn-success">Activar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
    </div>
</div>
    
<div class="modal fade" id="elecciones" tabindex="-1" aria-labelledby="Elecciones" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content margin-top-20">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="Elecciones">Nuevo Partido</h5>
            </div>

        <div class="modal-body">
        <form enctype="multipart/form-data" action='Agregar.php' method="POST">

        <div class="mb-3">
                <label for="nombrepartido">Nombre del partido</label>
                <input class="form-control" id="nombrepartido" name='nombre'>
            </div>

            <div class="mb-3">
                <label for="descripcionpartido">Descripción del partido</label>
                <input class="form-control" id="descripcionpartido"name='descripcion'>
            </div>

            <div class="mb-3">
                <label for="logo">Logo</label>
                <input type="file" class="form-control" id="logo" name="logo">
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
