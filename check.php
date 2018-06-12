<?php
session_start();
include 'lib/config.php';

ini_set('error_reporting',0);

if(!isset($_SESSION['usuario']))
{
  header("Location: login.php");
}
?>

<?php
if(isset($_GET['id'])) {

	$id = mysqli_real_escape_string($connect, $_GET['id']);

	//quitamos la notificacion
	mysqli_query($connect, "UPDATE notificaciones SET leido = '1' WHERE tipo = 'te ha etiquetado en una publicacion' AND leido = '0' AND de = $id AND para = '".$_SESSION['id']."'");

	header("Location: perfil.php?id=".$_SESSION['id']."&perfil=etiquetado");

}

?>