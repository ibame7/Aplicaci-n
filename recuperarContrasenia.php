<?php
session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
  header("Location:index.php");
  exit;
} else {
  echo '
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="estilos/styleRegistro.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <div class="title">¿Has olvidado tu contraseña?</div>
    <div class="content">
    <br>
    <h3>Rellena tus datos para cambiar la contraseña</h3>
      <form action="#">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Nombre</span>
            <input type="text" id="nombre" placeholder="Nombre" >
          </div>
          <div class="input-box">
            <span class="details">Usuario</span>
            <input type="text" id="usuario" placeholder="Usuario" >
          </div>
          <div class="input-box">
            <span class="details">Primer Apellido</span>
            <input type="text" id="primerApellido" placeholder="Primer Apellido" >
          </div>
          <div class="input-box">
            <span class="details">Segundo Apellido</span>
            <input type="text" id="segundoApellido" placeholder="Segundo Apellido" >
          </div>
          <div class="input-box">
            <span class="details">Nueva contraseña</span>
            <input type="password" id="contrasenia" placeholder="Contraseña" >
          </div>
          <div class="input-box">
            <span class="details">Confirmar contraseña</span>
            <input type="password" id="confirmarContrasenia" placeholder="Confirmar contraseña" >
          </div>
        </div>
        <a class="error"></a>
        <div class="button">
          <input type="submit" id="botonRecuperar" value="Register">
        </div>
      </form>
    </div>
  </div>
</body>
<script src="js/scriptLogin.js"></script>
</html>';
}