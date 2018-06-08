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

	$consulta=mysqli_query($connect, "SELECT id_user
        FROM
        usuarios WHERE id_user = '$id'");
	$peticion=mysqli_fetch_array($consulta);

	mysqli_query($connect, "UPDATE notificaciones SET leido = '1' WHERE tipo = 'te ha etiquetado en una publicacion' AND de = '".$peticion['id_user']."' AND para = '".$_SESSION['id']."'");

	header("Location: perfil.php?id=".$_SESSION['id']."&perfil=etiquetado");

}

?>