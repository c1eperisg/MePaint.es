<?php
session_start();
include 'lib/config.php';

ini_set('error_reporting',0);

if(!isset($_SESSION['usuario']))
{
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<htmL>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EDITAR MI PERFIL</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Personal styles -->
  <link rel="stylesheet" type="text/css" href="css/styles.css" />
  <!-- fav icon -->
  <link rel="icon" type="image/gif" href="images/fav_icon.png" />
  <!-- Despliegue el minimenú -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


<!-- START HEADER -->
<header class="main-header">

    <a href="index.php" class="logo">
      <span class="logo-lg">ME<b>PAINT</b></span>
    </a>

    <nav class="navbar navbar-static-top">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          
          <?php
          $noti = mysqli_query($connect, "SELECT * FROM notificaciones WHERE para = '".$_SESSION['id']."' AND leido = '0' ORDER BY id_not desc");
          $cuantas = mysqli_num_rows($noti);
          ?>

          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $cuantas; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes <?php echo $cuantas; ?> notificaciones</li>
              <li>
                <ul class="menu">

                <?php                
                while($no = mysqli_fetch_array($noti)) {

                $users = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '".$no['de']."'");
                $usa = mysqli_fetch_array($users);
                ?>

                  <li>
                    <center>
                    <?php if ($no['tipo'] == 'quiere ser tu amigo') { ?>
                        <i class="fa fa-users text-aqua"></i> <?php echo $usa['nombre']; ?> <?php echo $no['tipo']; ?>
                   <?php } else { ?>
                     <a href="check.php?id=<?php echo $usa['id_user']; ?>">
                      <i class="fa fa-users text-aqua"></i><?php echo $usa['nombre']; ?> <?php echo $no['tipo']; ?>
                    </a>
                    </span>
                  <?php } ?>
                  </center>
                  </li>

                <?php } ?>


                </ul>
              </li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="avatars/<?php echo $_SESSION['avatar']; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ucwords($_SESSION['nombre']); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img class="cursor-point" onclick="location.href='perfil.php?id=<?php echo $_SESSION['id'];?>';" src="avatars/<?php echo $_SESSION['avatar']; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo ucwords($_SESSION['nombre']); ?>
                  <small>Miembro desde <?php echo $_SESSION['fecha_reg']; ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="editarperfil.php?id=<?php echo $_SESSION['id'];?>" class="btn btn-default btn-flat">Editar perfil</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
<!-- END HEADER -->

<!-- SIDE BAR -->
  <aside class="main-sidebar">
    <section class="sidebar" style="color: white;">
      <div class="user-panel">
        <div class="pull-left">
          <img src="avatars/<?php echo $_SESSION['avatar']; ?>" width="50" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo ucwords($_SESSION['nombre']); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="post" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="encontrar-usuario" class="form-control" placeholder="Encuentra a tus amigos">
              <span class="input-group-btn">
                <button type="submit" name="searchEncont" id="search-btn2" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
       <?php 
       if (isset($_POST['searchEncont'])) {
            $nomUserEncon = mysqli_real_escape_string($connect, $_POST['encontrar-usuario']);

            if ($nomUserEncon!= "") {

                    $busqueda = mysqli_query($connect, "SELECT * FROM usuarios WHERE nombre LIKE '%{$nomUserEncon}%' AND id_user != '".$_SESSION['id']."'");
                    $contar = mysqli_num_rows($busqueda);

                    if($contar > 0) {
                      ?>
                      <div class="box-header">

                      <?php

                      while ($encontrado = mysqli_fetch_array($busqueda)) {
                        $idBuscado = $encontrado['id_user'];
                        $nombreBuscado = $encontrado['nombre'];
                        $avatarBuscado = $encontrado['avatar'];
                        ?>

                        <div class="user-block search-results" onclick="location.href='perfil.php?id=<?php echo $idBuscado;?>';">
                        <!-- Logo usuario -->
                        <img class="img-circle" src="avatars/<?php echo $avatarBuscado; ?>" alt="User Image">
                        <!-- Nombre usuario -->
                        <span class="description" >
                        <?php echo $nombreBuscado;?>
                        </span>
                      </div>

                      <?php 
                      }
                      ?>
                    </div>
                    <?php
                    } else{
                      echo "<center class='red-text'>No hay usuarios con ese nombre</br> :(</center>";
                    }

                  }else{
                    echo "<center class='red-text'>No has introducido ningun caracter</center>";
                  }

                  }

        ?>
    </section>
  </aside>
<!-- END LEFT SIDE -->

<?php
if(isset($_GET['id']))
{
$id = mysqli_real_escape_string($connect, $_GET['id']);

$miuser = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$id'");
$use = mysqli_fetch_array($miuser);

if($_SESSION['id'] != $id) {
?>
<script type="text/javascript">window.location="login.php";</script>
<?php
}
?>
  <div class="content-wrapper">

    <section class="content">

      <div class="row">
        <div class="col-md-8">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar mi perfil</h3>
            </div>
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre completo</label>
                  <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" value="<?php echo $use['nombre'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Usuario</label>
                  <input type="text" name="usuario" class="form-control" placeholder="Usuario" value="<?php echo $use['usuario'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $use['email'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Cambiar mi avatar</label>
                  <input type="file" name="avatar">
                </div>
                <div class="checkbox">
                  <label>
                    <input type="radio" value="H" name="sexo" <?php if($use['sexo'] == 'H') { echo 'checked'; } ?>> Hombre <br>
                    <input type="radio" value="M" name="sexo" <?php if($use['sexo'] == 'M') { echo 'checked'; } ?>> Mujer
                  </label>
                </div>
              </div>

              <div class="box-footer">
                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar datos</button>
              </div>
            </form>
          </div>

          <?php
          if(isset($_POST['actualizar']))
          {
            $nombre = mysqli_real_escape_string($connect, $_POST['nombre']);
            $usuario = mysqli_real_escape_string($connect, $_POST['usuario']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $sexo = mysqli_real_escape_string($connect, $_POST['sexo']);

            $comprobar = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM usuarios WHERE usuario = '$usuario' AND id_user != '$id'"));
            if($comprobar == 0){

            $type = 'jpg';
            $rfoto = $_FILES['avatar']['tmp_name'];
            $name = $id.'.'.$type;

            if(is_uploaded_file($rfoto))
            {
              $destino = 'avatars/'.$name;
              $nombrea = $name;
              copy($rfoto, $destino);
            }
            else
            {
              $nombrea = $use['avatar'];
            }

            $sql = mysqli_query($connect, "UPDATE usuarios SET nombre = '$nombre', usuario = '$usuario', email = '$email', sexo = '$sexo', avatar = '$nombrea' WHERE id_user = '$id'");
            $recarga = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$id'");
            $rec=mysqli_fetch_array($recarga);
             $_SESSION['nombre'] = $rec['nombre'];
            $_SESSION['avatar'] = $rec['avatar'];
            $_SESSION['usuario'] = $rec['usuario'];

            if($sql) {echo "<script type='text/javascript'>window.location='editarperfil.php?id=$_SESSION[id]';</script>";}

            } else {echo '<p style="color: red;">El nombre de usuario ya está en uso, escoja otro</p>';}

          }
          ?>


        </div>      

      </div>
    </section>
  </div>
  <div class="control-sidebar-bg"></div>

</div>

<!-- jQuery -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

</body>
</html>
<?php } ?>