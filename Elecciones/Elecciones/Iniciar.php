<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../../PhpMyAdmin/IDataBase2.php';
require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once 'Elecciones.php';
require_once '../../Constructor/Elecciones.php';

session_start();

if (isset($_SESSION['administracion'])) {
    $admin = json_decode($_SESSION['administracion']);
} else {
    header('Location: ../Login/Login.php');
}

if (isset($_SESSION['elecciones'])) {
    header('Location: ../Login/Login.php');
}

$layout = new Layout(true, false);
$inicio = new Eleccion('../../PhpMyAdmin');

if (isset($_POST['nombre'])) {
    if ($_POST['nombre'] == "" || $_POST['nombre'] == null) {

        echo "<script>alert('Debe introducir un nombre a la elección para iniciarla');</script>";

    } else {

        $inicio->Add($_POST['nombre']);
    }
}

if (isset($_GET['id_voto'])) {
    $completa = $inicio->getById($_GET['id_voto']);
    $_SESSION['elecciones'] = json_encode($completa);

    header("Location: Admin.php");
}

?>

<?php $layout->Header(); ?>

<h1 class="margin-top-2 text-center text-dark"><strong>Crea tus elecciones</strong></h1>

<div class="d-flex justify-content-center margin-top-4 margin-left-5">
    <div class="fadeInDown">
        <div id="formContent">
            
        <div class="modal-body">
            <h3 class="margin-top-4 text-center text-dark margin-bottom-2"><strong>Elecciones</strong></h3>
            
            <div class="fadeIn first">
                <img src="../../assets/Img/Almacenamiento/votar.png" class="icon margin-bottom-3" alt="User Icon"/></div>
                
            <form action="Iniciar.php" method="POST">
                <input type="text" class="input-space margin-top-2" id="documento" class="fadeIn second" name="nombre"required placeholder="Nombre de la elección">
                <input type="submit" class="fadeIn fourth bg-dark" name="boton" value="Iniciar elección">
            </form>
        </div>

    <div id="formFooter">
      <a class="underlineHover text-danger" href="Iniciar.php">Cargar la pagina</a>
    </div>
  </div>
</div>

<?php $layout->Footer(); ?>