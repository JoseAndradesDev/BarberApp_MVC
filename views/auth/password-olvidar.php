<h1 class="nombre-pagina">¿Olvidaste tu contraseña?</h1>
<p class="desc-pagina">rellena el formulario para restablecer tu contraseña por email</p>

<?php
    include_once __DIR__ . "/../templates/alertas.php"
?>

<form class="form" method="POST" action="">
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            placeholder="Escribe tu email"
            name="email"
        />
    </div>
 
    <input type="submit" class="btn-inicio" value="Restablecer contraseña"/>
</form>


<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Registrate</a>
    <a href="/">¿Ya tienes una cuenta? Inicia sesion</a>
</div>