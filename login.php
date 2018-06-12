<?php
session_start();
include 'lib/config.php';

if(isset($_SESSION['usuario']))
{
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ME PAINT</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" type="text/css" href="css/styles.css" />
  <!-- fav icon -->
  <link rel="icon" type="image/gif" href="images/fav_icon.png" />
</head>
<body class="hold-transition login-page">
<div class="login-box">


  <div class="login-logo">
    <img src="images/fav_icon.png" alt="Logo MePaint" height="50" width="50">
    <a href="">ME<b>PAINT</b></a>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg">Bienvenido!</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="usuario" pattern="[a-zA-Z0-9 ]{1,20}">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="contrasena" pattern="[a-zA-Z0-9 ]{1,20}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
        </div>
      </div>
    </form>

    <?php
    if(isset($_POST['login']))

    {

      $usuario = mysqli_real_escape_string($connect, $_POST['usuario']);
      $usuario = strip_tags($_POST['usuario']);
      $usuario = trim($_POST['usuario']);

      $contrasena = mysqli_real_escape_string($connect, md5($_POST['contrasena']));
      $contrasena = strip_tags(md5($_POST['contrasena']));
      $contrasena = trim(md5($_POST['contrasena']));

      $query = mysqli_query($connect, "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'");
      $contar = mysqli_num_rows($query);

      if($contar == 1) 

      {

        while($row=mysqli_fetch_array($query)) 

        {

          if($usuario = $row['usuario'] && $contrasena = $row['contrasena'])

          {

            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['id'] = $row['id_user'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['avatar'] = $row['avatar'];
            $_SESSION['fecha_reg'] = $row['fecha_reg'];
            header('Location: index.php');

          }

        }
        
      } else { echo 'Los datos ingresados no son correctos'; }


    }

    ?>

    <br>

    <a href="registro.php" class="text-center">Registrarme en ME <b>PAINT</b></a>

  </div>
</div>

<!-- jQuery -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
