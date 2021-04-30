<?php
require_once '../../Layouts/Layout.php';
require_once '../../helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../../PhpMyAdmin/IDataBase2.php';
require_once 'Elecciones.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../../PhpMyAdmin/IDataBase2.php';
require_once '../Candidatos/Candidatos.php';
require_once '../Partidos/Partidos.php';
require_once '../PuestoElectivo/Puesto.php';
require_once '../../Constructor/Elecciones.php';
require_once '../../Constructor/Votaciones.php';
require_once '../../Constructor/Candidatos.php';
require_once '../../Constructor/Partidos.php';
require_once '../../Constructor/Puestos.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDatabase2.php';
require_once '../Elecciones/Elecciones.php';

session_start();


$datos = new Eleccion('../../PhpMyAdmin');

if(isset($_GET['id_elecciones'])) {

    $cedula = $_GET['id_elecciones'];

    $datos->Deshabilitar($cedula);


}
unset($_SESSION['elecciones']);

header('Location: ../Login/Admin.php');


?>