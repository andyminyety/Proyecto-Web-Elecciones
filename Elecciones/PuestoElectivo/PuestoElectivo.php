<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../PuestoElectivo/Puesto.php';
require_once '../../Constructor/Puestos.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

$layout = new Layout(true, false);
$datapuestos = new Puesto('../../PhpMyAdmin');
$puestos = $datapuestos->getAll();

?>

<?php $layout->Header(); ?>

<div class="row">
    <div class="col-md-10"></div>
    <a class="btn btn-dark margin-top-1" data-bs-toggle="modal" data-bs-target="#elecciones">
        Agregar Puesto</a>
    <div class="col-md-8"></div>
</div>

<div class="row">
    <?php if ($puestos == "" || $puestos == null) : ?>

        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="text-center margin-top-2"><strong>No hay puesto agregados</strong></h2>
            <p class="text-center">Por favor agregar uno.</p>
            <div class="text-center"><img src="../../assets/Img/Almacenamiento/no disponible.png" class="icon" alt="User Icon"></div>
        </div>
        <div class="col-md-6"></div>
    </div>

    <?php else : ?>
    <?php foreach ($puestos as $puesto) : ?>
    
    <div class="col-md-6">
        <div class="bs-example shadows">
        <div class="modal-header text-white bg-dark">
            <h5 class="modal-title ">Puesto - <?= $puesto->nombre; ?></h5>
        </div >
            <div class="row no-gutters">
                <div class="col-sm-4">
                <div class="text-center"><img src="../../assets/Img/Almacenamiento/puesto.png" width="165" height="165"></div>
                </div>
            
                <div class="col-sm-8">
                    <div class="card-body">
                        <p class="card-title"><?= $puesto->descripcion; ?></h5>
                    <div> 
                        <a href="../PuestoElectivo/Editar.php?id_puesto=<?= $puesto->id_puesto; ?>" class="btn btn-dark float-end margin margin-top-1">Editar</a>
                        <a href="../Candidatos/ListarCandidatos.php?id_puesto=<?= $puesto->id_puesto; ?>" class="btn btn-warning float-end margin-top-1">Detalles</a>
                    
                    <?php if ($puesto->estado == 1) : ?>
                        <a href="Desactivar.php?id_puesto=<?= $puesto->id_puesto; ?>" class="btn btn-danger float-end margin margin-top-1">Desactivar</a>
                    <?php else : ?>
                        <a href="Activar.php?id_puesto=<?= $puesto->id_puesto; ?>" class="btn btn-success float-end margin margin-top-1">Activar</a>
                    <?php endif; ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="modal fade" id="elecciones" tabindex="-1" aria-labelledby="Elecciones" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content margin-top-20">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="Elecciones">Nuevo Puesto Electivo</h5>
            </div>

        <div class="modal-body">
        <form action='Agregar.php' method="POST">

            <div class="mb-3">
                <label for="nombrepuesto">Nombre del puesto</label>
                <input class="form-control" id="nombrepuesto" name='nombre' required>
            </div>

            <div class="mb-3">
                <label for="descripcionpuesto">Descripción</label>
                <input class="form-control" id="descripcionpuesto" name='descripcion' required>
            </div>

            <div style="margin-left: 63%;">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button id="mybutton" class="btn btn-dark float-end" type="submit">Agregar</button>
            </div>
        </form>
        </div>
        </div>
    </div>
</div>

<?php $layout->Footer(); ?>

<script type="text/javascript">

$("#mybutton").click(function(){
  alert('El puesto ha sido añadido correctamente.');
  });

</script>