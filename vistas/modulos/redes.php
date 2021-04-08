<?php

require_once "./controladores/footerControlador.php";
$classFooter= new footerControlador();

$files=$classFooter->datos_footer_controlador();
$rows=$files->fetch();

?>
  <!--Redes Sociales-->
  <div class="contenedorSocial">
        <ul class="social">
            <li class="social"><a href="mailto:<?php echo $rows['InfoEmail']?>" class="social">E-mail</a><i
                    class="fa fa-at gmail icon"></i></li>
            <li class="social"><a href="<?php echo $rows['InfoTwitter']?>" target="_blank" class="social">Twitter</a>
                <i class="fa fa-twitter twitter icon"></i></li>
            <li class="social"><a href="<?php echo $rows['InfoFacebook']?>" target="_blank" class="social">Facebook</a><i
                    class="fa fa-facebook facebook icon"></i></li>
        </ul>
    </div>