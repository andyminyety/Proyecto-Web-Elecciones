<?php

    require_once '../../Layouts/Layout.php';
    require_once '../../Helpers/File/JsonFile.php';
    require_once '../../PhpMyAdmin/IDataBase.php';
    require_once '../Partidos/Partidos.php';
    require_once '../PuestoElectivo/Puesto.php';
    require_once '../../Constructor/Puestos.php';
    require_once '../../Constructor/Partidos.php';
    require_once '../../Constructor/Candidatos.php';
    require_once 'Candidatos.php';

    session_start();

    $layout       = new Layout(true, false);
    $datospartidos = new Partido('../../PhpMyAdmin');
    $datospuestos  = new Puesto('../../PhpMyAdmin');
    $servicio     = new Candidato('../../PhpMyAdmin');

    $partidos = $datospartidos->getActive();
    $puestos  = $datospuestos->getActive();

    if (isset($_SESSION['administracion'])) {
        $admin = json_decode($_SESSION['administracion']);
    } else {
        header('Location: ../Login/Login.php');
    }

    if (isset($_GET['id'])) {
        $idcandidato   = $_GET['id'];
        $candidato     = $servicio->getById($idcandidato);
        $estado        = $candidato->estado;
    }
    if (isset($_POST['id_candidato']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['id_partido']) && isset($_POST['id_puesto']) && isset($_POST['estado'])) {
       
        $candidatos = new Candidatos();
        $candidatos->id_candidato = $_POST['id_candidato'];
        $candidatos->nombre       = $_POST['nombre'];
        $candidatos->apellido     = $_POST['apellido'];
        $candidatos->id_partido   = $_POST['id_partido'];
        $candidatos->id_puesto    = $_POST['id_puesto'];
        $candidatos->foto         = $_FILES['foto'];
        $candidatos->estado       = $_POST['estado'];

        $servicio->Edit($candidatos);
        header("Location: ListarCandidatos.php");
        exit();
     
    }
?>

<?php $layout->Header();?>       

<div class="row margin-top-6">
            <div class="col-md-3"></div>
            <div class="col-md-6 margin-bottom-5">
                <div class="card shadows">
                    <div class="modal-header text-white bg-dark">
                        <h5 class="modal-title h4" id="NuevoStudentLabel">Editar Candidato</h5>
                    </div>
                
                    <div class="modal-body">
                        <form enctype="multipart/form-data" action="Editar.php" method="POST">
                            <input type="hidden" name='id_candidato' value="<?=$idcandidato;?>">
                            
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Candidato</label>
                                <input class="form-control" id="nombrecandidato" name="nombre" value="<?=$candidato->nombre;?>">
                            </div>

                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido del Candidato</label>
                                <input class="form-control" id="apellidocandidato" name="apellido" value="<?=$candidato->apellido;?>">
                            </div>

                            <div class="mb-3">
                                <label for="id_partido">Partido</label>
                                <select class="form-control" name="id_partido" id="id_partido">
                                            
                                <?php foreach ($partidos as $partido): ?>
                                    <option value='<?=$partido->id_partido;?>'><?=$partido->nombre;?></option>
                                    
                                    <?php endforeach;?>
                                </select>
                            </div>
                            
                            <div class="mb-3 ">
                                <label for="id_puesto">Puesto</label>
                                <select class="form-control" name="id_puesto" id="id_puesto">
                                    
                                <?php foreach ($puestos as $puesto): ?>
                                    <option value='<?=$puesto->id_puesto;?>'><?=$puesto->nombre;?></option>
                                    
                                    <?php endforeach;?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="foto">Foto del candidato</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                            </div>

                            <input type="hidden" name='estado' value="<?=$estado;?>">

                            <div style="margin-left: 69.5%;">
                                <a href="ListarCandidatos.php" class="btn btn-danger float-end">Volver</a>
                                <button class="btn btn-dark float-end" type="submit">Editar</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<?php $layout->Footer();?>