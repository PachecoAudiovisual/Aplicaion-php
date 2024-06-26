<h1 class="nomre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">LLena el siguiente formulario para crear tu cuenta</p>

<?php 
include_once __DIR__ . '/../templates/alertas.php'
?>


<form class="formulario" method="POST" action="/crear-cuenta">
<div class="campo">
    <label for="nombre"> Nombre </label>
        <input 
        type="text" 
        name="nombre" 
        id="nombre"
        placeholder="Tu nombre"
        value="<?php echo s($usuario->nombre); ?>"
        />
</div>
<div class="campo">
    <label for="apellido"> Tu apellido </label>
        <input 
        type="text" 
        name="apellido" 
        id="apelido"
        placeholder="Tu apellido"
        value="<?php echo s($usuario->apellido); ?>"
        />
</div>
<div class="campo">
    <label 
    for="telefono">Telefono</label>
    <input 
    type="tel" 
    id="telefono"
    placeholder="Tu numero telefónico"
    name="telefono"
    value="<?php echo s($usuario->telefono); ?>"
    />
</div>
<div class="campo">
    <label 
    for="email">Email</label>
    <input 
    type="email"
    id="email"
    placeholder="Tu E-mail"
    name="email"
    value="<?php echo s($usuario->email); ?>"
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

<input type="submit"
value="Crear cuenta"
class="boton"
    />
   
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/olvide">Olvidé mi password</a>
</div>

