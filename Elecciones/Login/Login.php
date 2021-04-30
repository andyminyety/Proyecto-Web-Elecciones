<?php

require_once '../../Layouts/Layout.php';
require_once '../../Helpers/File/JsonFile.php';
require_once '../../PhpMyAdmin/IDataBase.php';
require_once '../../PhpMyAdmin/IDataBase2.php';
require_once 'Administracion.php';
require_once '../../Constructor/Administrador.php';

session_start();

$usuario = new Administracion('../../PhpMyAdmin');

if(isset($_SESSION['ciudadano'])) {
    header('Location: ../../index.php');
}

if (isset($_SESSION['administracion'])) {

    header('Location: Admin.php');
}

if (isset($_POST['usuario']) && isset($_POST['clave'])) {

	$admin = $usuario->getAdministrador($_POST['usuario'], $_POST['clave']);
	if ($admin == true) {

		$_SESSION['administracion'] = json_encode($admin);
		
		header('Location: Admin.php');
		
	} else {
		
		echo "<script> alert('Usuario o contraseña incorrecta.'); </script>";
	}
}

$layout = new Layout(true, true);

?>

<?php $layout->Header(); ?>

<div class="margin-top-9">
	<div class="d-flex justify-content-center margin-top-9">
		<div class="user_card fadeInDown">
			<div class="d-flex justify-content-center">
				<div class="brand_logo_container">
					<img src="../../assets/Img/Almacenamiento/logo.jpeg" class="brand_logo" alt="Logo">
					<h2 class="margin-top-20"><strong>Login</strong></h2>
				</div>
			</div>
			
			<div class="d-flex justify-content-center form_container">
				
				<form action="Login.php" method="POST">
					<div class="input-group mb-3">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input name="usuario" id="usuario" class="form-control input_user" placeholder="Usuario" required>
					</div>
				
					<div class="input-group mb-2">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" id="clave" name="clave" class="form-control input_pass" placeholder="Contraseña"required >
					</div>
					
					<div class="dlogin_container center">
						<button  class="btn-block btn btn-danger margin-top-8 float-end" type="submit">Iniciar sesión</button>
                    </div>
				</form>
			</div>
		</div>  
	</div>
</div>

<?php $layout->Footer(); ?>