<?php 
$id = mysqli_real_escape_string($connect, $_GET['id']);
$consultasEtiquetado ="SELECT *
        FROM
        publicaciones WHERE para = $id
        ORDER BY
        id_pub";
    $consultaEt=mysqli_query($connect, $consultasEtiquetado);
    while ($listaEt=mysqli_fetch_array($consultaEt)) {

        $fechaEt = mysqli_real_escape_string($connect, $listaEt['fecha']);
        $contenidoEt = mysqli_real_escape_string($connect, $listaEt['contenido']);

        $userEtiquetador = mysqli_real_escape_string($connect, $listaEt['usuario']);

        $userEtiquetadorb = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$userEtiquetador'");
        $useb = mysqli_fetch_array($userEtiquetadorb);

        $userEtiquetadob = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$id'");
        $useparab = mysqli_fetch_array($userEtiquetadob);

    
        ?>
    <!-- START PUBLICACIONES -->
          <!-- Box Comment -->
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
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Descripción publicación -->
              <p><?php echo $contenidoEt;?></p>

              <!-- En caso de que haya imagen que mostrar -->
              <?php 
              if($listaEt['imagen'] != 0)
              {
              ?>
              <img src="publicaciones/<?php echo $listaEt['imagen'];?>" width="50%">
              <?php
              }
              ?>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.col -->
        <!-- END PUBLICACIONES -->

        <?php 
        } ?>