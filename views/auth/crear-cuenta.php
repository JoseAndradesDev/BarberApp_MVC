<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="desc-pagina">Llena el siguiente formulario para crear una nueva cuenta</h1>

<?php
    include_once __DIR__ . "/../templates/alertas.php"
?>


<form class="form" method="POST" action="/crear-cuenta">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Escribe tu nombre"
            value="<?php echo s($usuario->nombre)?>"
        />
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input 
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Escribe tu apellido"
            value="<?php echo s($usuario->apellido)?>"
        />
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input 
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Escribe tu telefono"
            value="<?php echo s($usuario->telefono)?>"
        />
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Escribe tu email"
            value="<?php echo s($usuario->email)?>"
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Escribe tu password"
        />
    </div>

    <input type="submit" class="btn-crear" value="Crear cuenta"/>

</form>

<div class="acciones">
    <a href="/password-olvidado">¿Olvidaste tu contraseña? Recuperala</a>
    <a href="/">¿Ya tienes una cuenta? Inicia sesion</a>
</div>