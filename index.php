<?php
session_start();
include 'lib/config.php';

ini_set('error_reporting',0);
$baneado = mysqli_query($connect, "SELECT ban FROM usuarios WHERE id_user = '".$_SESSION['id']."' ");

  $ban = mysqli_fetch_array($baneado);

if(!isset($_SESSION['usuario']))
{
  header("Location: login.php");
} elseif ($ban['ban'] == 1) {
    header("Location: logout.php");
}
?>
<!DOCTYPE html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ME PAINT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Archivos modificar el input file -->
  <link rel="stylesheet" type="text/css" href="css/component.css" />
  <!-- Estilos personalizados -->
  <link rel="stylesheet" type="text/css" href="css/styles.css" />
  <!-- fav icon -->
  <link rel="icon" type="image/gif" href="images/fav_icon.png" />
  <!-- codigo scroll -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/jquery.jscroll.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<!-- START HEADER -->
<header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">ME<b>PAINT</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          
          <?php
          $noti = mysqli_query($connect, "SELECT * FROM notificaciones WHERE para = '".$_SESSION['id']."' AND leido = '0' ORDER BY id_not desc");
          $cuantas = mysqli_num_rows($noti);
          ?>

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?php echo $cuantas; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tienes <?php echo $cuantas; ?> notificaciones</li>
              <li>
                <!-- inner menu: contains the actual data -->
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
                     <a href="check.php?id=<?php $usa['user_id']; ?>">
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

          <!-- User Account: style can be found in dropdown.less -->
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
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="color: white;">
      <!-- Sidebar user panel -->
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

    <!-- Script validar caracteres -->
    <script type="text/javascript">    
    function validarn(e) {
    tecla = (document.all) ? e.keyCode : e.which;
   if (tecla==8) return true;
   if (tecla==9) return true;
   if (tecla==11) return true;
    patron = /[A-Za-zñ!#$%&()=?¿¡*+0-9-_á-úÁ-Ú :;,.]/;
 
    te = String.fromCharCode(tecla);
    return patron.test(te);
} 
    </script>
    <!-- Script validar caracteres -->

      
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- /.box -->
          <div class="row">

            
            <!-- Publicaciones -->
            <div class="col-md-12">              
              <div class="box box-primary direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Qué quieres compartir?</h3>

                 
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
              </div>

              <!-- /.box-body -->
                <div class="box-footer">

                  <form style="margin-bottom: 10px;" action="" method="post" enctype="multipart/form-data">
                    <div class="input-group col-md-4">
                      <input id="etiquetado" value="<?php echo $_POST['buscarUsuarioEtiquetar']; ?>" type="text" name="buscarUsuarioEtiquetar" class="form-control" placeholder="Etiqueta a un amigo!">
                          <span class="input-group-btn">
                            <button type="submit" name="searchUserPost" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                            </button>
                          </span>
                    </div>

                  </form>
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                      <textarea name="publicacion" onkeypress="return validarn(event)" placeholder="¿Qué quieres compartir?" class="form-control" cols="200" rows="3" required></textarea>
                      <br><br><br><br>
                      
                    <!-- START Input file nuevo diseño .-->
                      <input type="file" name="foto" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"/>

                      <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Sube una foto</span></label>
                      <input style="display: none;" type="text" name="idEleg" id="idElegido" value="" required>
                      
                    <!-- END Input file nuevo diseño .-->
                    <br>

                      <button type="submit" name="publicar" class="btn btn-primary btn-flat">Publicar</button>
                    </div>
                  </form>
                  <?php 
                 if (isset($_POST['searchUserPost'])) {
                      $nomUser = mysqli_real_escape_string($connect, $_POST['buscarUsuarioEtiquetar']);

                      if ($nomUser!= "") {

                         //$amigos = mysql_query("SELECT * FROM amigos WHERE de = '$id' AND para = '".$_SESSION['id']."' OR de = '".$_SESSION['id']."' AND para = '$id'");

                              $busqueda = mysqli_query($connect, "SELECT usuarios.* FROM usuarios, amigos WHERE (amigos.de = usuarios.id_user AND amigos.para = '".$_SESSION['id']."' AND amigos.estado = 1 AND usuarios.nombre LIKE '%{$nomUser}%' AND usuarios.id_user != '".$_SESSION['id']."') OR (amigos.para = usuarios.id_user AND amigos.de = '".$_SESSION['id']."' AND amigos.estado = 1 AND usuarios.nombre LIKE '%{$nomUser}%' AND usuarios.id_user != '".$_SESSION['id']."')");

                              $contar = mysqli_num_rows($busqueda);
                              if($contar > 0) {

                                ?>
                                <div class="box-header" id="resultadoBusquedaEtiquetado">
                                  <form action="">

                                <?php

                                while ($encontrado = mysqli_fetch_array($busqueda)) {
                                  $idBuscado = $encontrado['id_user'];
                                  $nombreBuscado = $encontrado['nombre'];
                                  $avatarBuscado = $encontrado['avatar'];
                                  ?>
                                    
                                   <div class="user-block search-results-post" onclick="
                                    document.getElementById('resultadoBusquedaEtiquetado').parentNode.removeChild(document.getElementById('resultadoBusquedaEtiquetado'));
                                    document.getElementById('etiquetado').value = '<?php echo $nombreBuscado; ?>';
                                    document.getElementById('idElegido').value = '<?php echo $idBuscado; ?>';
                                   ">
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
                                </form>
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
                  <?php
                  if(isset($_POST['publicar'])) 
                  {
                    $publicacion = mysqli_real_escape_string($connect, $_POST['publicacion']);

                    $result = mysqli_query($connect, "SHOW TABLE STATUS WHERE 'Name' = 'publicaciones'");
                    $data = mysqli_fetch_assoc($result);
                    $next_increment = $data['Auto_increment'];

                    $alea = substr(strtoupper(md5(microtime(true))), 0,12);
                    $code = $next_increment.$alea;

                    $type = 'jpg';
                    $rfoto = $_FILES['foto']['tmp_name'];
                    $name = $code.".".$type;

                    if (is_uploaded_file($rfoto)) {
                      $destino = "publicaciones/".$name;
                      $nombre = $name;
                      copy($rfoto, $destino);
                    }else{
                      $nombre = "";
                    }

                    $idEl = mysqli_real_escape_string($connect, $_POST['idEleg']);

                    $subir = mysqli_query($connect, "INSERT INTO publicaciones (usuario, fecha, contenido, imagen, para) VALUES ('".$_SESSION['id']."', now(), '$publicacion', '$nombre', '$idEl')");
                    mysqli_query($connect, "INSERT INTO notificaciones (de, para, tipo, leido, fecha) VALUES ('".$_SESSION['id']."','$idEl','te ha etiquetado en una publicacion','0',now())");

                    if ($subir) {
                      echo '<script>window.Location="index.php"</script>';
                    }

                  }      
                  ?>           
                </div>
                <!-- /.box-footer-->
              </div>
              <!--/.direct-chat -->
            </div>
            <!-- /.col -->            
          </div>
          <!-- /.row -->


          <!-- codigo scroll -->
          <div class="scroll">
            <?php require_once 'publicaciones.php'; ?>
          </div>

            <script>
            //Simple codigo para hacer la paginacion scroll
            $(document).ready(function() {
              $('.scroll').jscroll({
                loadingHtml: '<img src="images/invisible.png" alt="Loading" />'
            });
            });
            </script>
          <!-- codigo scroll -->


        </div>

        <div class="col-md-4">          

          <!-- PRODUCT LIST -->
          <?php $amistade = mysqli_query($connect, "SELECT * FROM amigos WHERE para = '".$_SESSION['id']."' AND estado = '0' order by fecha desc");
             $contar = mysqli_num_rows($amistade);

              if($contar > 0) 

              { ?>
          <div class="box box-primary">
            
            <div class="box-header with-border">
              <h3 class="box-title">Solicitudes de amistad</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">

              <?php 
              while($am = mysqli_fetch_array($amistade)) { 

                $use = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '".$am['de']."'");
                $us = mysqli_fetch_array($use);
                ?>
                <li class="item">
                  <div class="product-img">
                    <img src="avatars/<?php echo $us['avatar']; ?>" alt="Product Image">
                  </div>
                  <div class="product-info">
                  <?php echo $us['nombre']; ?>
                      <a href="solicitud.php?action=aceptar&id=<?php echo $am['id_amigo']; ?>"><span class="label label-success pull-right">Aceptar</span></a>
                      <br>
                      <a href="solicitud.php?action=rechazar&id=<?php echo $am['id_amigo']; ?>"><span class="label label-danger pull-right">Rechazar</span></a>
                        <span class="product-description">
                          <?php echo $us['sexo']; ?>
                        </span>
                  </div>
                </li>
                <!-- /.item -->

                <?php } ?>


              </ul>
            </div>
            <!-- /.box-footer -->
          </div>
        <?php } ?>
          <!-- /.box -->
        </div>
        <!-- /.col -->


        <div class="col-md-4">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Nuevos en me<b>Paint</b></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  <?php $registrados = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user!='".$_SESSION['id']."' order by id_user desc limit 8");
                  while($reg=mysqli_fetch_array($registrados)) 
                  {
                  ?>
                    <li>
                      <img src="avatars/<?php echo $reg['avatar']; ?>" alt="User Image" width="100" height="200">
                      <span class="description" onclick="location.href='perfil.php?id=<?php echo $reg['id_user'];?>';" style="cursor:pointer; color: #3C8DBC;">
                      <?php echo $reg['nombre'];?>
                      </span>
                      <span class="users-list-date"><?php echo $reg['fecha_reg'];?></span>
                    </li>
                  <?php
                  }
                  ?>

                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->


      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- Sparkline -->
<!-- JS modificar diseño input file -->
<script src="js/custom-file-input.js"></script>
</body>
</html>
