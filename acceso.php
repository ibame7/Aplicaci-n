<?php 
session_start();

if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
    header("Location:index.php");
    exit;
} else {
    echo '
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="imagenes/icono.ico" />
    <link rel="stylesheet" href="estilos/styleAcceso.css">
    <title>Acceso</title>
</head>

<body>
    <div class="login">
        <div class="login-screen">
            <div class="app-title">
                <h1>Bienvenido</h1>
            </div>
            <div class="login-form">
                <form method="post">
                    <div class="control-group">
                        <input type="text" class="login-field" name="username"  placeholder="usuario"
                            id="login-name">
                        <label class="login-field-icon fui-user" for="login-name"></label>
                    </div>
                    <div class="control-group">
                        <input type="password" class="login-field" name="password"  placeholder="contraseña"
                            id="login-pass">
                        <label class="login-field-icon fui-lock" for="login-pass"></label>
                    </div>
                    <input type="submit" id="boton" value="Acceder">
                </form>
                <a class="error"></a>
                <a class="login-link" href="recuperarContrasenia.php">¿Has olvidado tu contraseña?</a>
                <a class="login-link" id="volver" href="registro.php">Registrarse</a>
                <br>
                <a class="login-link" id="volver" href="index.php">Volver</a>
            </div>
        </div>
    </div>
</body>
<script src="js/scriptLogin.js"></script>

</html>';
}