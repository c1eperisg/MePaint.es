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
	$action = mysqli_real_escape_string($connect, $_GET['action']);


	if($action == 'aceptar') {
		//aceptamos la peticion
		mysqli_query($connect, "UPDATE amigos SET estado = '1' WHERE de = '$id' AND para = '".$_SESSION['id']."'");
		//quitamos la notificacion
		mysqli_query($connect, "UPDATE notificaciones SET leido = '1' WHERE tipo = 'quiere ser tu amigo' AND leido = '0' AND de = $id AND para = '".$_SESSION['id']."'");
		header('Location:' . getenv('HTTP_REFERER'));

	}

	if($action == 'rechazar') {
		//rechazamos la petición
		mysqli_query($connect, "DELETE FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."'");
		//quitamos la notificacion
		mysqli_query($connect, "UPDATE notificaciones SET leido = '1' WHERE tipo='quiere ser tu amigo' AND leido = '0' AND de = $id AND para = '".$_SESSION['id']."'");
		header('Location:' . getenv('HTTP_REFERER'));

	}

}

?>