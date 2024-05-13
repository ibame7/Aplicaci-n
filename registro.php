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
    <title> Registro</title>
    <link rel="stylesheet" href="estilos/styleRegistro.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form action="#">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Nombre</span>
            <input type="text" id="nombre" placeholder="Nombre" required>
          </div>
          <div class="input-box">
            <span class="details">Usuario</span>
            <input type="text" id="usuario" placeholder="Usuario" required>
          </div>
          <div class="input-box">
            <span class="details">Primer Apellido</span>
            <input type="text" id="primerApellido" placeholder="Primer Apellido" required>
          </div>
          <div class="input-box">
            <span class="details">Segundo Apellido</span>
            <input type="text" id="segundoApellido" placeholder="Segundo Apellido" required>
          </div>
          <div class="input-box">
            <span class="details">Contraseña</span>
            <input type="password" id="contrasenia" placeholder="Contraseña" required>
          </div>
          <div class="input-box">
            <span class="details">Confirmar contraseña</span>
            <input type="password" id="confirmarContrasenia" placeholder="Confirmar contraseña" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" id="email" placeholder="Email" required>
          </div>
        </div>
        <div class="button">
          <input type="submit" id="botonRegistro" value="Register">
        </div>
      </form>
    </div>
  </div>
</body>
<script src="js/scriptLogin.js"></script>
</html>';
}