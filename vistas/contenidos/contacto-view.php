

    <!--Contenido-->
    <section class="contactenos">
        <div class="contenedor-sectio-contactenos">
            Esta en : <a href="">Contactenos </a>
        </div>
        <h2>Contactenos</h2>
        <h3> Gracias por visitarnos
            <br>¿Qué podemos hacer por ti?
            <br>Contáctanos diligenciando este formulario para poder resolver tus dudas, sugerencias o solicitudes
        </h3>
        <div class="contenedor-section-contactenos">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1986.6104094300704!2d-72.67460141432885!3d5.227970126594798!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7a62fca3f206c9e1!2sI.%20E.%20Leon%20De%20Greiff!5e0!3m2!1ses!2sco!4v1602379329647!5m2!1ses!2sco">
            </iframe>
            <h6>Vereda Monterralo<br>
                Aguazul, Casanare</h6>
        </div>

 
        <div class="contenedor-section-contactenos">
        <form  action="" method="POST" data-form="save"  class="contact_form" autocomplete="off" enctype="multipart/form-data">
                    <ul>

                        <li>
                            <input type='text' name='nombre-reg' id='Nombre' placeholder="Nombre *" required="">
                            <span class="form_hint">Formato correcto: "Nombre(s)"</span>
                        </li>
                        <li>
                            <input type='email' name='email-reg' id='E-mail' placeholder="tu@correo.com *" required="">
                            <span class="form_hint">Formato correcto: "ejemplo@hotmail.com"</span>
                        </li>
                        <li>
                            <input type='text' name='telefono-reg' id='Telefono' placeholder="Teléfono *" required="">
                            <span class="form_hint">Formato correcto: "310 258 1620 (10 digitos)"</span>
                        </li>
                        <li>
                            <input type='text' name='asunto-reg' id='Asunto' placeholder="Asunto *" required="">
                            <span class="form_hint">Formato correcto: "Asunto"</span>
                        </li>
                        <li>
                            <textarea name="mensaje-reg" cols="40" rows="6"
                                placeholder="Escriba el mensaje aquí.. *" required=""></textarea>
                            <span class="form_hint">Escriba el mensaje aquí..</span>

                        </li>
                        <li>
                            <input type='file' name='file-reg' id='archivo' accept=".jpg, .png, .jpeg, .pdf" placeholder="carga tu archivo" >
                           
                        </li>
                        <span><small>Tamaño máximo del archivo adjunto 2MB. Tipos de archivo permitido .jpg, .png, .jpeg, .pdf </small></span>
                        <br> <br>                  
                        <li align='center'>
                            <button class="submit" type='submit' >Enviar</button>
                            <button class="reset" type='reset'>Cancelar</button>
                        </li>
                    </ul>
            </form>

        </div>

        </section>
       

    <section class="contactenos">

        <h3> <i class="fa fa-calendar-o" aria-hidden="true"> Horaro de atención</i>  </h3>
        <h5>Lunes a Vinernes<br>
            7:00am - 3:00pm</h5>

    </section>

<!--footer-->

<?php include "./vistas/modulos/footer.php"; ?>