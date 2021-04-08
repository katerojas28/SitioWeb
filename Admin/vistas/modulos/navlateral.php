<section class="full-box cover dashboard-sideBar">
		<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
		<div class="full-box dashboard-sideBar-ct">
			<!--SideBar Title -->
			<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
			<?php echo COMPANY; ?> <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
			</div>
			<!-- SideBar User info -->
			<div class="full-box dashboard-sideBar-UserInfo">
			<figure class="full-box">
					<img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $_SESSION['foto_ielg'];?>" alt="UserIcon">
					<figcaption class="text-center text-titles"><?php echo $_SESSION['nombre_ielg'];?></figcaption>
					<figcaption class="text-center text-titles"><?php echo $_SESSION['apellido_ielg'];?></figcaption>
				</figure>

				<?php 
					if($_SESSION['tipo_ielg']=="Administrador"){
						$tipo="admin";
					}else{
						$tipo="user";
					}
				?>

				<ul class="full-box list-unstyled text-center">
					<li>
						<a href="<?php echo SERVERURL; ?>mydata/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_ielg']); ?>/" title="Mis datos">
							<i class="zmdi zmdi-account-circle"></i>
						</a>
					</li>
					<li>
						<a href="<?php echo SERVERURL; ?>myaccount/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_ielg']); ?>/" title="Mi cuenta">
							<i class="zmdi zmdi-settings"></i>
						</a>
					</li>
					<li>
						<a href="<?php echo $lc->encryption($_SESSION['token_ielg']); ?>" title="Salir del sistema" class="btn-exit-system">
							<i class="zmdi zmdi-power"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- SideBar Menu -->
			<ul class="list-unstyled full-box dashboard-sideBar-Menu">
				<li>
					<a href="<?php echo SERVERURL; ?>home/">
						<i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Inicio
					</a>
				</li>
				<?php if($_SESSION['privilegio_ielg']==1):?>
				<li>
					<a href="<?php echo SERVERURL; ?>adminlist/">
						<i class="zmdi zmdi-account-add zmdi-hc-fw"></i> Administrador
					</a>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-globe zmdi-hc-fw"></i> Administración <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
					
						<li>
							<a href="<?php echo SERVERURL; ?>publicacioneslist/"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Pagina Principal</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>nosotroslist/"><i class="zmdi zmdi-labels zmdi-hc-fw"></i> Nosotros</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>documentlist/"><i class="zmdi zmdi-collection-pdf zmdi-hc-fw"></i> Documentos</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>normalist/"><i class="zmdi zmdi-file-text zmdi-hc-fw"></i> Normatividad</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>funcionariolist/"><i class="zmdi zmdi-account-box zmdi-hc-fw"></i> Funcionarios</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>galerialist/"><i class="zmdi zmdi-collection-image-o zmdi-hc-fw"></i> Galeria</a>
						</li>
						<?php endif;?>
						<li>
							<a href="<?php echo SERVERURL; ?>materia/"><i class="zmdi zmdi-graduation-cap"></i> Grados</a>
						</li>
						<?php if($_SESSION['privilegio_ielg']==1):?>
					</ul>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-settings"></i> Configuraciones <i class="zmdi zmdi-caret-down pull-right"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="<?php echo SERVERURL; ?>infolist/"><i class="zmdi zmdi-info-outline zmdi-hc-fw"></i> Información</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>asiglist/"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Materias</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>bannerlist/"><i class="zmdi zmdi-image-alt zmdi-hc-fw"></i> Banner</a>
						</li>
						<li>
							<a href=""><i class="zmdi zmdi-calendar-alt zmdi-hc-fw"></i> Eventos</a>
						</li>
						<li>
							<a href="<?php echo SERVERURL; ?>anunciolist/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_ielg']); ?>/"><i class="zmdi zmdi-comment-edit zmdi-hc-fw"></i> Anuncios</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="<?php echo SERVERURL; ?>mensajelist/">
					<i class="zmdi zmdi-email"></i> Mensajes
					</a>
				</li>
				<?php endif;?>
			</ul>
		</div>
	</section>