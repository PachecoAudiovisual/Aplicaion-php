<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina"> Escribe tu nuevo password a continuación</p>

<?php 
include_once __DIR__ . '/../templates/alertas.php'
?>
<?php 
if ($error)return; 
?>


<form class="formulario" method="POST" >

<div class="campo">
    <label 
    for="password">Password</label>
    <input 
    type="password"
    id="password"
    placeholder="Tu nuevo password"
    name="password"
    />
</div>

<input
    type="submit"
    class="boton-verde boton"
    value="Guardar nuevo password"
    />
</form>


<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>
