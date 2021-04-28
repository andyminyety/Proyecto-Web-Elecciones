<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/DataBaseConnection.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../../Constructor/Ciudadanos.php';
require_once '../../Elecciones/Ciudadanos/Ciudadanos.php';
require_once '../../Elecciones/PuestoElectivo/Puesto.php';

session_start();

if (isset($_SESSION['administracion'])) {

    header('Location: ../../Elecciones/Login/Admin.php');
}

if (isset($_SESSION['ciudadano'])) {

    header('Location: ../../index.php');
}

$layout = new Layout(true,true);
$ciudadano = new Ciudadano('../../PhpMyAdmin');

if(isset($_POST['cedula'])) {

    $ciudadanos = $ciudadano->getCiudadanoByCedula($_POST['cedula']);
    if(isset($_SESSION['elecciones'])) {

        if($ciudadanos == true) {
            $_SESSION['ciudadano'] = json_encode($ciudadanos);

            header('Location: ../../index.php');
            
        }

    }else {

        echo "<script alert('No hay elecciones activa.')</script>";
    }
    
} 
?>
<?php $layout->Header(); ?>

<h1 class="margin-top-2 text-center text-dark"><strong>Bienvenido a las Elecciones del 2021</strong></h1>

<div class="d-flex justify-content-center margin-top-4">
    <div class="fadeInDown">
        <div id="formContent">

        <div class="modal-body">
            <h3 class="margin-top-4 text-center text-dark margin-bottom-2"><strong>Elecciones</strong></h3>
        
            <div class="fadeIn first">
                <img src="../../assets/Img/Almacenamiento/votar.png" class="icon margin-bottom-3" alt="User Icon"/></div>
                
            <form action="Login.php" method="POST">
                <input type="text" class="input-space margin-top-2" id="documento" class="fadeIn second" name="cedula" required placeholder="Introduzca su cédula">
                <input type="submit" class="fadeIn fourth bg-dark" name="boton" value="Iniciar votación">
            </form>
        </div>

        <div id="formFooter">
            <a class="underlineHover text-danger btn-delete" href="../../index.php">Cargar la pagina</a>
        </div>
    </div>
</div>

<?php $layout->Footer(); ?>