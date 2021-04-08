
        

<!--ANUNCIOS INTERNOS-->


<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles">Anuncio <small>Interno</small></h1>
	</div>
	<?php 
        require_once "./controladores/anuncioControlador.php";
        $IAnuncio= new anuncioControlador();
        echo $IAnuncio->listado_anuncios_controlador(3);
	 ?>
	 

</div>

<?php if($_SESSION['privilegio_ielg']==1):?>
<!--REGISTROS DE CANTIDAD DE USUARIOS REGISTRADOS-->
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles">System <small>Tiles</small></h1>
			</div>
		</div>
        <div class="full-box text-center" style="padding: 30px 10px;">
        

        <?php
            require"./controladores/administradorControlador.php";
            $IAdmin= new administradorControlador();
            $CAdmin=$IAdmin->datos_administrador_controlador("Conteo", 0);
            $CAdminDoc=$IAdmin->datos_administrador_controlador("Conteo1", 0);
        ?>

			<article class="full-box tile">
				<div class="full-box tile-title text-center text-titles text-uppercase">
					Administradores
				</div>
				<div class="full-box tile-icon text-center">
                <i class="zmdi zmdi-assignment-account"></i>
				</div>
				<div class="full-box tile-number text-titles">
					<p class="full-box"><?php echo $CAdmin->rowCount(); ?></p>
					<small>Registros</small>
				</div>
			</article>
			<article class="full-box tile">
				<div class="full-box tile-title text-center text-titles text-uppercase">
					Docentes
				</div>
				<div class="full-box tile-icon text-center">
                <i class="zmdi zmdi-accounts-alt"></i>
				</div>
				<div class="full-box tile-number text-titles">
					<p class="full-box"><?php echo $CAdminDoc->rowCount(); ?></p>
					<small>Registros</small>
				</div>
			</article>
        </div>


<!--LINEA DE TIEMPO DEL LOS RESGISTROS DE LA BITACORA DE INGRESO AL PANEL-->

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles">Registro <small>TimeLine</small></h1>
	</div>
	<section id="cd-timeline" class="cd-container">
     <?php 
        require_once "./controladores/bitacoraControlador.php";
        $IBitacora= new bitacoraControlador();
        echo $IBitacora->listado_bitacora_controlador(5);
     ?>
    </section>
</div>
<?php endif;?>