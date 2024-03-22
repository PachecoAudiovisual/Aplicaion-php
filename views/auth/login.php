<h1 class="nombre-pagina">Peluqueria unisex</h1>
<p class="descripcion-pagina"> Ingresa tus datos</p>

<?php 
include_once __DIR__ . '/../templates/alertas.php'
?>

<form class="formulario" method="POST" action="/">
<div class="campo">
    <label 
    for="email">Email</label>
    <input 
    type="email"
    id="email"
    placeholder="Tu email"
    name="email"
    
    />
</div>

<div class="campo">
    <label 
        for="password">Password</label>
    <input 
        type="password"
        id="password"
        name="password"
        placeholder="Tu contraseña"
    />
</div>

    <button 
    type="submit"
    class="boton-verde boton">Iniciar sesión</button>

</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/olvide">Olvidé mi password</a>
</div>