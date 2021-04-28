<?php

require_once '../../Layouts/Layout.php';
require_once '../../helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once 'Elecciones.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../Candidatos/Candidatos.php';
require_once '../Partidos/Partidos.php';
require_once '../PuestoElectivo/Puesto.php';
require_once '../../Constructor/Elecciones.php';
require_once '../../Constructor/Votaciones.php';
require_once '../../Constructor/Candidatos.php';
require_once '../../Constructor/Partidos.php';
require_once '../../Constructor/Puestos.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $administrador = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

$layout = new Layout(true, false);
$datos = new Eleccion('../../PhpMyAdmin');
$datoscandidato = new Candidato('../../PhpMyAdmin');
$datospartido = new Partido('../../PhpMyAdmin');
$datospuesto = new Puesto('../../PhpMyAdmin');
$elecciones = $datos->getAll();
$cambio = false;
$candidatosresultado = $datoscandidato->getActiveAll();
$partidosresultado = $datospartido->getActive();
$puestosresultado = $datospuesto->getActive();

if (count($candidatosresultado) > 1 && count($partidosresultado) > 1 && count($puestosresultado) > 0) {

    $cambio = true;
}

?>

<?php $layout->Header(); ?>
<div class="row">
    <div class="col-md-10"></div>
    <?php if (isset($_SESSION['elecciones'])) : ?>
        <a class="btn btn-dark margin-top-1" href="Terminar.php">Terminar elecciones.</a></div>
    <?php elseif ($cambio == true) : ?>
        <a class="btn btn-dark margin-top-1" href="Iniciar.php">Iniciar elecciones.</a></div>
    <?php elseif ($cambio == false) : ?>
        <script>alert('Debe tener dos candidatos, partidos y puesto activo para iniciar una elección.')</script>
    <?php endif; ?>
    <div class="col-md-8"></div>
</div>

<?php if ($elecciones == "" || $elecciones == null) : ?>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2 class="text-center margin-top-6"><strong>No hay elecciones almacenadas</strong></h2>
            <p class="text-center">Por favor iniciar una elección.</p>
            <div class="text-center"><img src="../../assets/Img/Almacenamiento/no disponible.png" class="icon" alt="User Icon"></div>
        </div>
        <div class="col-md-6"></div>
    </div>

<?php else : ?>
    <?php foreach ($elecciones as $eleccion) : ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h2 class="center margin-top-2"><strong><?= $eleccion->nombre; ?></strong></h2>

                <table class="table table-hover table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">Candidatos</th>
                            <th scope="col">Partidos</th>
                            <th scope="col">Puestos</th>
                            <th scope="col">Votos Totales</th>
                            <th scope="col">Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $candidatoid = $datos->getEleccionesCandidatos($eleccion->id_elecciones); ?>
                        <?php foreach ($candidatoid as $idcandidato) : ?>
                            <tr>
                                <?php $candidato = $datoscandidato->getById($idcandidato->id_candidato);
                                echo '<th scope="row">' . $candidato->nombre . ' ' . $candidato->apellido . '</th>';

                                ?>
                                <?php $partidoid = $datos->getEleccionesPartidos($eleccion->id_elecciones, $idcandidato->id_candidato); ?>
                                <?php foreach ($partidoid as $idpartido) : ?>

                                    <?php $partido = $datospartido->getById($idpartido->id_partido);
                                    echo '<td>' . $partido->nombre . '</td>';

                                    ?>

                                    <?php $puestoid = $datos->getEleccionesPuestos($eleccion->id_elecciones, $idcandidato->id_candidato); ?>
                                    <?php foreach ($puestoid as $idpuesto) : ?>
                                        <?php $puesto = $datospuesto->getById($idpuesto->id_puesto);
                                        echo '<td>' . $puesto->nombre . '</td>';

                                        ?>

                                        <?php $resultado = $datos->getEleccionesVotoFinal($eleccion->id_elecciones, $idcandidato->id_candidato); ?>

                                        <td><?= $resultado->resultado; ?></td>

                                        <?php $total = $datos->getEleccionesByID($eleccion->id_elecciones); ?>
                                        <td><?= $resultado->resultado * 100 / $total->resultado; ?>%</td>


                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php $layout->Footer(); ?>