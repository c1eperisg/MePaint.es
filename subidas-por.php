<?php 
$id = mysqli_real_escape_string($connect, $_GET['id']);
$consultasEtiquetado ="SELECT * FROM publicaciones WHERE usuario = $id ORDER BY id_pub DESC";
/* Mostrará primeor las publicaciones más recientes */
    $consultaEt=mysqli_query($connect, $consultasEtiquetado);
    while ($listaEt=mysqli_fetch_array($consultaEt)) {

        $fechaEt = mysqli_real_escape_string($connect, $listaEt['fecha']);
        $contenidoEt = mysqli_real_escape_string($connect, $listaEt['contenido']);

        $userEtiquetadorb = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$id'");
        $useb = mysqli_fetch_array($userEtiquetadorb);

        $userEtiquetado = mysqli_real_escape_string($connect, $listaEt['para']);

        $userEtiquetadob = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$userEtiquetado'");
        $useparab = mysqli_fetch_array($userEtiquetadob);

        ?>
    <!-- START PUBLICACIONES -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <!-- Logo usuario publicador -->
                <img class="img-circle" src="avatars/<?php echo $useparab['avatar']; ?>" alt="User Image">
                <!-- Nombre usuario y fecha de la publicación -->
                <span class="description">
                <?php echo $useparab['nombre'];?>
                </span>
                <span class="description"><?php echo $fechaEt;?></span>
                <span class="description">Subida por <?php echo $useb['nombre'];?></span>
              </div>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <!-- Descripción publicación -->
              <p><?php echo $contenidoEt;?></p>

              <!-- En caso de que haya imagen que mostrar -->
              <?php 
              if($listaEt['imagen'] != 0)
              {
              ?>
              <img style="max-width: 500px; max-height: 500px;" src="publicaciones/<?php echo $listaEt['imagen'];?>">
              <?php
              }
              ?>

            </div>

        </div>
        <!-- END PUBLICACIONES -->
        <?php 
        } ?>