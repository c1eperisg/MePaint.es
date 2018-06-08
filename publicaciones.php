<?php
include 'lib/config.php';
?>
<script type="text/javascript" src="js/likes.js"></script>

<?php
	$consultavistas ="SELECT publicaciones.*
        FROM
        publicaciones, amigos WHERE (amigos.de = publicaciones.para AND amigos.para = '".$_SESSION['id']."' AND amigos.estado = 1) OR (amigos.para = publicaciones.para AND amigos.de = '".$_SESSION['id']."' AND amigos.estado = 1)
        ORDER BY
        id_pub DESC";
	$consulta=mysqli_query($connect, $consultavistas);
	while ($lista=mysqli_fetch_array($consulta)) {

		$userid = mysqli_real_escape_string($connect, $lista['usuario']);

		$usuariob = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$userid'");
    $use = mysqli_fetch_array($usuariob);

    $useridpara = mysqli_real_escape_string($connect, $lista['para']);

    $usuariobpara = mysqli_query($connect, "SELECT * FROM usuarios WHERE id_user = '$useridpara'");
    $usepara = mysqli_fetch_array($usuariobpara);

	?>
	<!-- START PUBLICACIONES -->
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <!-- Logo usuario publicador -->
                <img class="img-circle" src="avatars/<?php echo $usepara['avatar']; ?>" alt="User Image">
                <!-- Nombre usuario y fecha de la publicación -->
                <span class="description" onclick="location.href='perfil.php?id=<?php echo $usepara['id_user'];?>';" style="cursor:pointer; color: #3C8DBC;">
                <?php echo $usepara['nombre'];?>
                </span>
                <span class="description"><?php echo $lista['fecha'];?></span>
                <span class="description">Subida por <span onclick="location.href='perfil.php?id=<?php echo $use['id_user'];?>';" style="cursor:pointer; color: #3C8DBC;"><?php echo $use['nombre'];?></span></span>
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
              <p><?php echo $lista['contenido'];?></p>

              <!-- En caso de que haya imagen que mostrar -->
              <?php 
              if($lista['imagen'] != 0)
              {
              ?>
              <img src="publicaciones/<?php echo $lista['imagen'];?>" width="50%">
              <?php
          	  }
          	  ?>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.col -->
        <!-- END PUBLICACIONES -->
    
    <br><br>

	<?php
	}
	//Validmos el incrementador par que no genere error
	//de consulta.  
    if($IncrimentNum<=0){}else {
	echo "<a href=\"publicaciones.php?pag=".$IncrimentNum."\">Seguiente</a>";
	}
?>