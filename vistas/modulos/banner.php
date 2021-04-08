<?php

require_once "./controladores/bannerControlador.php";
$classBanner= new bannerControlador();

$files=$classBanner->datos_banner_controlador();
$campos=$files->fetchAll();

?>
 <!--Banner-->
 <div class="banner-contenedor">
        <div class="contenedor">
            <div class="swiper-container">
                <div class="swiper-wrapper">

                <?php foreach($campos as $rows):?>
                    <div class="swiper-slide">
                        <div class="imgBx">
                            <img src="data:<?php echo $rows['BannerTipImg'] ?>;base64,<?php echo base64_encode(stripslashes($rows['BannerImg']));?>" />
                            <div class="carousel-caption">
                                <p><?php echo $rows['BannerDescripcion']?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>	
                
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <script type="text/javascript" src="<?php echo SERVERURL; ?>vistas/js/Plugins/swiper.min.js"></script>
            <!-- Initialize Swiper -->
            <script>
                var swiper = new Swiper('.swiper-container', {
                    spaceBetween: 30,
                    centeredSlides: true,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            </script>

        </div>
    </div>