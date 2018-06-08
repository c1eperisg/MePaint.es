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

	$consulta=mysqli_query($connect, "SELECT id_user
        FROM
        usuarios INNER JOIN amigos ON usuarios.id_user = amigos.de AND amigos.id_amigo = '$id'");
	$peticion=mysqli_fetch_array($consulta);

if($action == 'aceptar') {

	$update = mysqli_query($connect, "UPDATE amigos SET estado = '1' WHERE id_amigo = '$id'");
	mysqli_query($connect, "UPDATE notificaciones SET leido = '1' WHERE tipo='quiere ser tu amigo' AND de = '".$peticion['id_user']."' AND para = '".$_SESSION['id']."'");
	header('Location:' . getenv('HTTP_REFERER'));


}

if($action == 'rechazar') {

	$delete = mysqli_query($connect, "DELETE FROM amigos WHERE id_amigo = '$id'");
	mysqli_query($connect, "UPDATE notificaciones SET leido = '1' WHERE tipo='quiere ser tu amigo' AND de = '$id' AND para = '".$_SESSION['id']."'");
	header('Location:' . getenv('HTTP_REFERER'));

}



}

?>