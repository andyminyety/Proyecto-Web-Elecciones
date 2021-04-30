<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../Constructor/Candidatos.php';
require_once '../../Constructor/Puestos.php';
require_once '../../Constructor/Partidos.php';
require_once 'Candidatos.php';
require_once '../Partidos/Partidos.php';
require_once '../PuestoElectivo/Puesto.php';
require_once '../../PhpMyAdmin/IDataBase.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../../Login/Login.php');
}

$layout = new Layout(true, false);
$datos = new Candidato('../../PhpMyAdmin');
$datospartido = new Partido('../../PhpMyAdmin');
$datospuesto = new Puesto('../../PhpMyAdmin');
$partidos = $datospartido->getActive();
$puestos = $datospuesto->getActive();

$candidatos = $datos->getActive();

if (isset($_GET['id_puesto'])) {
    $candidatos = $datos->getCandidatoByPuesto($_GET['id_puesto']);
}

?>

<?php $layout->Header(); ?>

<div class="row">
    <div class="col-md-10"></div>
    <a class="btn btn-dark margin-top-1" data-bs-toggle="modal" data-bs-target="#elecciones">
        Agregar Candidato</a>
    <div class="col-md-8"></div>
</div>

<div class="row">
    <?php if (empty($candidatos)) : ?>

        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="text-center margin-top-2"><strong>No hay candidatos agregados</strong></h2>
            <p class="text-center">Por favor agregar uno.</p>
            <div class="text-center"><img src="../../assets/Img/Almacenamiento/no disponible.png" class="icon" alt="User Icon"></div>
        </div>
        <div class="col-md-6"></div>

        <?php else : ?>
            <?php foreach ($candidatos as $candidato) : ?>
                <?php if ( $candidato->nombre == "Voto") : ?>

        
                <?php else : ?>  
                    <div class="bs-example shadows">
        <div class="card" style="max-width: 500px;">
            <div class="row no-gutters">
                <div class="col-sm-5">
                    <img width="210" height="210" src="<?php echo "../../assets/Img/Candidatos/" . $candidato->foto ?>" >
                </div>
                <div class="col-sm-7">
                    <div class="card-body">
                        <h4 class="card-text"><strong><?php echo $candidato->nombre; ?> <?php echo $candidato->apellido; ?></strong></h4>
                        <p class="card-title">Se postula como <?= $datospuesto->getById($candidato->id_puesto)->nombre; ?> 
                        para el partido <?= $datospartido->getById($candidato->id_partido)->nombre; ?>.</h5>
                    <div> 
                        <a href="Editar.php?id=<?php echo $candidato->id_candidato; ?>" class="btn btn-dark margin-top-1">Editar</a>
                        <?php if ($candidato->estado == 1) : ?>
                        <a href="Desactivar.php?id=<?= $candidato->id_candidato; ?>" class="btn btn-danger float-end margin-top-1">Desactivar</a>
                    <?php else : ?>
                        <a href="Activar.php?id=<?= $candidato->id_candidato; ?>" class="btn btn-success float-end margin-top-1">Activar</a>
                    <?php endif; ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
 
    <?php endif; ?> 
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php ?>

<div class="modal fade" id="elecciones" tabindex="-1" aria-labelledby="Elecciones" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content margin-top-20">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="Elecciones">Nuevo Candidato</h5>
            </div>

        <div class="modal-body">
        <form enctype="multipart/form-data" action='Agregar.php' method="POST">
        
            <div class="mb-3">  
                <label for="nombrecandidato">Nombre del Candidato</label>
                <input class="form-control" id="nombrecandidato" name='nombre' required>
            </div>

            <div class="mb-3">
                <label for="apellidocandidato">Apellido del Candidato</label>
                <input class="form-control" id="apellidocandidato" name='apellido' required>
            </div>

            <div class="mb-3">
                <label for="name">Partido</label>
                <select class="form-control" name="id_partido" id="id_partido" required>

                    <option>Seleccione una opción</option>

                    <?php foreach ($partidos as $parts) : ?>

                    <option value='<?=$parts->id_partido;?>'><?=$parts->nombre;?></option>

                    <?php endforeach; ?>
            
                </select>
            </div>

            <div class="mb-3">
                <label for="name">Puesto</label>
                <select class="form-control" name="id_puesto" id="id_puesto" required">

                    <option>Seleccione una opcion</option>
                    
                    <?php foreach ($puestos as $post): ?>

                    <option value='<?=$post->id_puesto;?>'><?=$post->nombre;?></option>

                    <?php endforeach;?>

                </select>
            </div>

            <div class="mb-3">
                <label for="logo">Foto</label>
                <input name="foto" type="file" class="form-control" id="foto" required>
            </div>

            <div style="margin-left: 63%;">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button id="mybutton" class="btn btn-dark float-end myButton" type="submit">Agregar</button>
            </div>
        </form>
        </div>
        </div>
    </div>
</div>


<?php $layout->Footer(); ?>

<script type="text/javascript">
$("#mybutton").click(function(){
  alert('El puesto ha sido creado correctamente.');
  });

</script>