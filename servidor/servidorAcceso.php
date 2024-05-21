<?php
use function Webmozart\Assert\Tests\StaticAnalysis\length;

header('Content-Type: application/json');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
session_start();
if(isset($_SESSION['usuario'])){
    header("Location:index.php");
    exit;
}else{

$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_POST['username']) && isset($_POST['password'])) {
    if (strlen($_POST['password']) < 4 || strlen($_POST['password']) > 10) {
        echo json_encode(['error' => 'La contraseña debe tener entre 4 y 10 caracteres']);
    } else {
        $username = $_POST['username'];
        $password = hash('sha256', $_POST['password']);

        try {
            $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die("Ha ocurrido un error. Avisa al soporte técnico");
        }
        
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
            echo json_encode(['error' => 'Usuario o contraseña incorrecta']);
        }
    }
} else {
    header("Location:index.php");
    exit;
}
}
