<?php
    include_once __DIR__ . '/../templates/barra.php'
?> 
<a class="btn-inicio admin" href="/admin">Volver</a>
<h3 class="nombre-pagina">Servicios</h3>
<p class="desc-pagina">- Administración de los servicios -</p>


<ul class="listado-servicios">
<?php foreach($servicios as $servicio){ ?>
    <li class="servicio" onclick="modificarServicio()">
            <p class="nombre-servicio"><?php echo $servicio->nombre; ?></p>
            <p class="precio-servicio"><?php echo $servicio->precio.'€'; ?></p>
            <input type="hidden" name="id" id="id" value="<?php echo $servicio->id; ?><">

            <div class="acciones">
                <a class="btn-crear" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Editar</a>
               <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id ?>">
                    <input type="submit" class="btn-eliminar" value="Eliminar">
                </form>
            </div>
    </li>

<?php } //fin foreach ?> 


</ul>





