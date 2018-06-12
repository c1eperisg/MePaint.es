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
  if(isset($_GET['id']))
  {
  $id = mysqli_real_escape_string($connect, $_GET['id']);
  if ($_GET['perfil'] == "") {
    $_GET['perfil'] = "subidas-por";
  }
  $pag = $_GET['perfil'];

  $infouser = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$id'");
  $use = mysqli_fetch_array($infouser);

  $amigos2 = mysqli_query($connect, "SELECT * FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."' OR de = '".$_SESSION['id']."' AND para = '$id'");
  $ami = mysqli_fetch_array($amigos2);
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $use['nombre']; ?> | ME PAINT</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap  -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Estilos personalizados -->
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

    <!-- Logo -->
    <a href="index.php" class="logo">
      <span class="logo-lg">ME<b>PAINT</b></span>
    </a>

    <nav class="navbar navbar-static-top">
      <!-- Navbar Right Menu -->
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

<!-- START LEFT SIDE -->
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
    <!-- /.sidebar -->
  </aside>
<!-- END LEFT SIDE -->


  <div class="content-wrapper">

    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="avatars/<?php echo $use['avatar'];?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $use['nombre'];?></h3>

              <ul class="list-group list-group-unbordered">
                <?php $amigos = mysqli_query($connect, "SELECT * FROM usuarios INNER JOIN amigos ON usuarios.id_user = amigos.de AND amigos.para = '$id' AND estado=1 OR usuarios.id_user = amigos.para AND amigos.de = '$id' AND estado=1 order by usuarios.nombre");
                   $totAmigos = mysqli_num_rows($amigos);
                ?>
                <li class="list-group-item">
                  <b>Amigos</b> <a class="pull-right"><?php echo $totAmigos; ?></a>
                </li>
                
              </ul>
              
              <?php if($_SESSION['id'] != $id) {?>
              <form action="" method="post">
              
              <?php if(mysqli_num_rows($amigos2) >= 1 AND $ami['estado'] == 0) { ?>
              <center><h4>Esperando respuesta</h4></center>
              <?php } else { ?>

              <?php if($ami['estado'] == 0) { ?>
              <input type="submit" class="btn btn-primary btn-block" name="enviarSolicitud" value="Enviar solicitud de amistad">
              <?php } ?>
              <?php if($ami['estado'] == 1) { ?>
              <input type="submit" class="btn btn-danger btn-block" name="eliminarAmigo" value="Eliminar como amigo">
              <?php } ?>


              <?php } ?>
              </form>
              <?php } ?>

              <?php
              if(isset($_POST['enviarSolicitud'])) {
                $add = mysqli_query($connect, "INSERT INTO amigos (de,para,fecha,estado) values ('".$_SESSION['id']."','$id',now(),'0')");

                mysqli_query($connect, "INSERT INTO notificaciones (de, para, tipo, leido, fecha) VALUES ('".$_SESSION['id']."','$id','quiere ser tu amigo','0',now())");

                if($add) {echo '<script>window.location="perfil.php?id='.$id.'"</script>';}
              }
              ?>

              <?php
              if(isset($_POST['eliminarAmigo'])) {
                $add = mysqli_query($connect, "DELETE FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."' OR de = '".$_SESSION['id']."' AND para = '$id'");
                if($add) {echo '<script>window.location="perfil.php?id='.$id.'"</script>';}
              }
              ?>
              
              <br>

            </div>
          </div>
          <!-- USERS LIST -->

          
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Amigos</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  <?php 
                  while($am=mysqli_fetch_array($amigos)) 
                  {
                    $idAmigo = $am['id_user'];
                  ?>
                    <li class="cursor-point" onclick="location.href='perfil.php?id=<?php echo $idAmigo;?>';">
                      <img src="avatars/<?php echo $am['avatar']; ?>" alt="User Image" width="100" height="200">
                      <a class="users-list-name" href="#"><?php echo $am['nombre']; ?></a>
                      <span class="users-list-date"><?php echo $am['fecha_reg']; ?></span>
                    </li>
                  <?php
                  }
                  ?>

                  </ul>
                </div>
              </div>

        </div>

        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?php echo $pag == 'subidas-por' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=subidas-por">Subidas por <?php echo $use['nombre']; ?></a></li>
              <li class="<?php echo $pag == 'etiquetado' ? 'active' : ''; ?>"><a href="?id=<?php echo $id;?>&perfil=etiquetado">Etiquetado</a></li>
            </ul>
            <div class="tab-content">

          <div class="scroll">


          <?php
          if($ami['estado'] != 0 OR $_SESSION['id'] == $use['id_user']) { ?>
          
            <?php
            $pagina = isset($_GET['perfil']) ? strtolower($_GET['perfil']) : 'subidas-por';
            require_once $pagina.'.php';
            ?>

          <?php } else { ?>

          <center><h2>Tu y <?php echo $use['nombre'] ?> todavía no sois amigos</h2></center>

          <?php } ?>

          </div>
              </div>
  
          </div>
        </div>
      </div>

    </section>
  </div>

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Bootstrap -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php

}
?>