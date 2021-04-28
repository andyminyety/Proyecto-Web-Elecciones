<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../Constructor/Candidatos.php';
require_once '../../Constructor/Puestos.php';
require_once '../../Constructor/Partidos.php';
require_once '../../Elecciones/Candidatos/Candidatos.php';
require_once '../../Elecciones/Partidos/Partidos.php';
require_once '../../Elecciones/PuestoElectivo/Puesto.php';
require_once '../../PhpMyAdmin/IDataBase.php';

session_start();

if(isset($_SESSION['cuidadano'])) {
    $ciudadano = json_encode($_SESSION['cuidadano']);
}

$layout = new Layout(true, true);
$datos = new Candidato('../../PhpMyAdmin');
$datospartido = new Partido('../../PhpMyAdmin');
$datospuesto = new Puesto('../../PhpMyAdmin');


$candidatos = $datos->getActive();

if (isset($_GET['id_puesto'])) {
    $candidatos = $datos->getCandidatoByPuesto($_GET['id_puesto']);
}

?>

<?php $layout->Header(); ?>

<div class="set">
    <div class="row margin-top-4">
        <?php if (empty($candidatos)) : ?>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2 class="text-center margin-top-4"><strong>No hay candidatos</strong></h2>
                <p class="text-center">Por favor volver al inicio.</p>
                <div class="text-center"><img src="../../assets/Img/Almacenamiento/out.png" class="icon" alt="User Icon"></div>
            </div>
        <div class="col-md-6"></div>
    </div>
    
    <?php else : ?>
    <?php foreach ($candidatos as $candidato) : ?>

     <?php if ($candidato->estado == 0) {

        }
        ?>
            
        <div class="col-md-3 margin-bottom-4">
            <div class="card shadows">
                <div class="modal-header text-white bg-dark">
                    <h5 class="modal-title h6" id="NuevoStudentLabel">Candidato - <?= $datospuesto->getById($candidato->id_puesto)->nombre; ?></h5>
                </div>
                
                <img class="bd-placeholder-img card-img-top" src="<?php echo "../../assets/Img/Candidatos/" . $candidato->foto ?>" width="250" height="240" aria-label="Placeholder: Thumbnail">
        
                 <div class="card-body">
                    <h5><strong class="card-title"><?php echo $candidato->nombre; ?>  <?php echo $candidato->apellido; ?></strong></h5>
                    <p class="card-text">Aspirante a <?= $datospuesto->getById($candidato->id_puesto)->nombre; ?> para el
                    partido <?= $datospartido->getById($candidato->id_partido)->nombre; ?></p>
                
                <a href="Votar.php?id_candidato=<?php echo $candidato->id_candidato; ?>" style="margin-left: 67%;" id="mybutton" class="btn btn-success">Votar</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    <?php ?>
    </div>
</div>

<?php $layout->Footer(); ?>
<script type="text/javascript">

$("#mybutton").click(function(){
  alert('Su verificación de voto se ha enviado a su correo correctamente.');
  });

</script>
