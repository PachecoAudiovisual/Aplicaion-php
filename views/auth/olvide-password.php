
<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina"> Ingresa tu e-mail a continuación</p>

<?php 
include_once __DIR__ . '/../templates/alertas.php';
?>


<form class="formulario" method="POST" action="/olvide">

<div class="campo">
    <label 
    for="email">Email</label>
    <input 
    type="email"
    id="email"
    placeholder="Tu E-mail"
    name="email"
    />
</div>

<input
    type="submit"
    class="boton-verde boton"
    value="Enviar instrucciones"
    />
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>