<?php 

require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../../Elecciones/Elecciones/Elecciones.php';
require_once '../../Elecciones/Candidatos/Candidatos.php';
require_once '../../Elecciones/PuestoElectivo/Puesto.php';
require_once '../../Elecciones/Partidos/Partidos.php';
require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../Constructor/Elecciones.php';
require_once '../../Constructor/Votaciones.php';
require_once '../../Constructor/Candidatos.php';
require_once '../../Constructor/Puestos.php';
require_once '../../Constructor/Partidos.php';
require_once '../../Helpers/Email/Exception.php';
require_once '../../Helpers/Email/PHPMailer.php';
require_once '../../Helpers/Email/SMTP.php';
require_once '../../Helpers/Email/Email.php';

session_start();

if(isset($_SESSION['ciudadano'])) {
    $ciudadanos = json_decode($_SESSION['ciudadano']);
}

if(isset($_SESSION['elecciones'])) {
    $elecciones = json_decode($_SESSION['elecciones']);
} else {

    header('Location: Login.php');
}

$eleccion = new Eleccion('../../PhpMyAdmin');
$candidato = new Candidato('../../PhpMyAdmin');
$puesto = New Puesto('../../PhpMyAdmin');
$partido = new Partido('../../PhpMyAdmin');
$email = new Email('../../Helpers/Email');

if(isset($_GET['id_candidato'])) {

    $idcandidato = $_GET['id_candidato'];
    $ciudadano = $candidato->getById($idcandidato);

    $eleccion->AddResultado($elecciones->id_elecciones,$idcandidato,$ciudadano->id_partido,$ciudadano->id_puesto,$ciudadanos->cedula);
    if($eleccion == true) {
        $puestos = $puesto->getById($ciudadano->id_puesto);
        $partidos = $partido->getById($ciudadano->id_partido);
        $body = "Saludos estimado/a " . "<strong>$ciudadanos->nombre</strong>" . " usted ha votado por el candidato ". "<strong>$ciudadano->nombre</strong>" . " " . "<strong>$ciudadano->apellido</strong>" . 
        " del partido " . "<strong>$partidos->nombre</strong>" . " el cual se postula para el puesto de " . "<strong>$puestos->nombre</strong>." . " ¡Gracias por ejercer su voto!.";
        $email->sendEmail($ciudadanos->email,"Tu Voto 2021", $body);
    }

    header('Location: ../../index.php');
}

?>