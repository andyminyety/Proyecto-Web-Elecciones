<?php 

session_start();

unset($_SESSION['administracion']);

header('location: Login.php');

?>