<?php
session_start();
include 'lib/config.php';

ini_set('error_reporting',0);

if(isset($_SESSION['usuario']))
{
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php ?> Registro</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <img src="images/fav_icon.png" alt="Logo MePaint" height="50" width="50">
    <a href="">ME<b>PAINT</b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Únetenos!</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" value="<?php echo $_POST['nombre']; ?>" required>
        <span class="glyphicon glyphicon-star form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $_POST['email']; ?>" required>  
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="usuario" class="form-control" placeholder="Usuario" value="<?php echo $_POST['usuario']; ?>" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="repcontrasena" class="form-control" placeholder="Repita la contraseña" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" name="registrar" class="btn btn-primary btn-block btn-flat">Registrarme</button>
        </div>
      </div>
    </form>


    <?php

    if(isset($_POST['registrar'])) {

      $nombre = mysqli_real_escape_string($connect, $_POST['nombre']);
      $email = mysqli_real_escape_string($connect, $_POST['email']);
      $usuario = mysqli_real_escape_string($connect, $_POST['usuario']);
      $contrasena = mysqli_real_escape_string($connect, md5($_POST['contrasena']));
      $repcontrasena = mysqli_real_escape_string($connect, md5($_POST['repcontrasena']));

      $comprobarusuario = mysqli_num_rows(mysqli_query($connect, "SELECT usuario FROM usuarios WHERE usuario = '$usuario'"));

      $comprobaremail = mysqli_num_rows(mysqli_query($connect, "SELECT email FROM usuarios WHERE email = '$email'"));

      if($comprobarusuario >= 1) { ?>

      <br>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        El nombre de usuario está en uso, por favor escoja otro
     </div>

     <?php } else {

        if($comprobaremail >= 1) { ?>

        <br>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          El email ya está en uso por favor escoja otro o verifique si tiene una cuenta
        </div>

        <?php } else {

          if($contrasena != $repcontrasena) { ?>

          <br>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Las contraseñas no coinciden
          </div>

          <?php } else {

            $insertar = mysqli_query($connect, "INSERT INTO usuarios (nombre,email,usuario,contrasena,avatar,fecha_reg) values ('$nombre','$email','$usuario','$contrasena','defect.jpg',now())");

            if($insertar) { ?>

            <br>
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Felicidades se ha registrado correctamente
            </div>

            <?php

            header("Refresh: 2; url = login.php");

            }

          }

        }

      }

    }

    ?>

    <br>
    <a href="login.php" class="text-center">Tengo actualmente una cuenta</a>
  </div>
</div>

<!-- jQuery -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
