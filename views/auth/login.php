<h1 class="nombre-pagina">Iniciar Sesión</h1>
<p class="desc-pagina">inicia sesión con tus datos</p>

<?php
    include_once __DIR__ . "/../templates/alertas.php"
?>


<form class="form" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            placeholder="Escribe tu email"
            name="email"
            value="<?php echo s($auth->email)?>"
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            placeholder="Escribe tu password"
            name="password"
        />
    </div>

    <input type="submit" class="btn-inicio" value="Iniciar sesion"/>
</form>


<div class="acciones">
    <a href="/password-olvidado">¿Olvidaste tu contraseña? Recuperala</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Registrate</a>
</div>