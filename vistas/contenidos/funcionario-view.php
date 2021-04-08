<?php
require_once "./controladores/funcionarioControlador.php";
$classFooter= new funcionarioControlador();

$files=$classFooter->datos_funcionario_controlador();
$row=$files->fetchAll();

?>

    <!--Contenido-->
    <section class="funcionarios">
        <div class="contenedor-sectio">
            Esta en : <a href="">Funcionarios </a>
        </div>
        <h2>Funcionarios</h2>

        <?php 
			require_once "./controladores/funcionarioControlador.php";
			$insFun = new funcionarioControlador();
		?>


            <?php
			$pagina = explode("/",$_GET['views']);
			echo $insFun-> paginador_funcionario_controlador($pagina[1], 3,);
			?>	


    </section>

    
    </section>

