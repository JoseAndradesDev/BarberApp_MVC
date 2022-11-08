<?php 
    include_once __DIR__ . '/../templates/barra.php'
?>
<a class="btn-inicio admin" href="/servicios">Volver</a>
<p class="desc-pagina">- Actualiza el servicio seleccionado -</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form method="POST" class="formulario admin">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    
<input type="submit" class="btn-crear admin" value="Actualizar Servicio">
</form>