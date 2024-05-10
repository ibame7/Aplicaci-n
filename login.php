<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$_POST = json_decode(file_get_contents('php://input'), true);
$username = $_POST['username'];
$password = $_POST['password'];

$bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');

$consulta = $bd->prepare("SELECT * FROM user WHERE username = :username AND contrasenia = :password");
$consulta->execute(['username' => $username, 'password' => $password]);

$usuario = $consulta->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    echo json_encode(['usuario' => $usuario]);
    session_name("IdUsuario");
    session_start();
    $_SESSION['usuario'] = $usuario['username']; // Establecer el nombre de usuario en la sesión
} else {
    echo json_encode(['error' => 'Usuario o contraseña incorrectos']);
}
?>
