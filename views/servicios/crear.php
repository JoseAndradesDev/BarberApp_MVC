<?php 
    include_once __DIR__ . '/../templates/barra.php'
?>
<a class="btn-inicio admin" href="/admin">Volver</a>
<p class="desc-pagina">- Crea un nuevo servicio rellenando el formulario -</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="/servicios/crear" method="POST" class="formulario admin">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    
<input type="submit" class="btn-crear admin" value="Crear Servicio">
</form>