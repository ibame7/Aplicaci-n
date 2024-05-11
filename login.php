<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
session_start();

    $_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');

    $consulta = $bd->prepare("SELECT * FROM user WHERE username = :username AND contrasenia = :password");
    $consulta->execute(['username' => $username, 'password' => $password]);

    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $resultadoAdmin = $bd->prepare("SELECT * FROM admin WHERE admin =:admin");
        $resultadoAdmin->execute(['admin' => $username]);
        $admin = $resultadoAdmin->fetch(PDO::FETCH_ASSOC);


        $resultadoPropietario = $bd->prepare("SELECT * FROM propietario WHERE propietario = :propietario");
        $resultadoPropietario->execute(['propietario' => $username]);
        $propietario = $resultadoPropietario->fetch(PDO::FETCH_ASSOC);


        $resultadoConsumidor = $bd->prepare("SELECT * FROM consumidor WHERE consumidor = :consumidor");
        $resultadoConsumidor->execute(['consumidor' => $username]);
        $consumidor = $resultadoConsumidor->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $tipo = "admin";
        } else if ($propietario) {
            $tipo = "propietario";
        } else if ($consumidor) {
            $tipo = "consumidor";
        }

        $_SESSION['usuario'] = $usuario; // Establecer el nombre de usuario en la sesión
        $_SESSION['tipo'] = $tipo;
        $usuarioFinal = array('usuario' => $_SESSION['usuario'], 'tipoUsuario' => $_SESSION['tipo']);
        echo json_encode($usuarioFinal);
    } else {
        echo json_encode(['error' => 'Usuario o contraseña incorrectos']);
    }

} else {
    echo json_encode(['error2' => 'No se recibieron los datos del usuario']);
}

