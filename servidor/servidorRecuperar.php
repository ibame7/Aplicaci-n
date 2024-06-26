<?php
use function Webmozart\Assert\Tests\StaticAnalysis\length;

header('Content-Type: application/json');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location:index.php");
    exit;
} else {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if (
        isset($_POST['nombre']) && isset($_POST['user']) &&
        isset($_POST['apellido1']) && isset($_POST['apellido2']) &&
        isset($_POST['contrasenia']) && isset($_POST['confirmarContrasenia']) &&
        !empty($_POST['nombre']) && !empty($_POST['user']) &&
        !empty($_POST['apellido1']) && !empty($_POST['apellido2']) &&
        !empty($_POST['contrasenia']) && !empty($_POST['confirmarContrasenia'])
    ) {
        if (
            strlen($_POST['contrasenia']) < 4 || strlen($_POST['contrasenia']) > 10 ||
            strlen($_POST['confirmarContrasenia']) < 4 || strlen($_POST['confirmarContrasenia']) > 10
        ) {
            echo json_encode(['error' => 'Ambas contraseñas debe tener entre 4 y 10 caracteres']);
        } else {
            if ($_POST['contrasenia'] != $_POST['confirmarContrasenia']) {
                echo json_encode(['error' => 'Ambas contraseñas deben ser iguales']);
            } else {
                $nombre = $_POST['nombre'];
                $usuario = $_POST['user'];
                $primerApellido = $_POST['apellido1'];
                $segundoApellido = $_POST['apellido2'];
                $contrasenia = hash('sha256', $_POST['contrasenia']);
                try {
                    $bd = new PDO('mysql:host=localhost;dbname=reservayjuega;charset=utf8', 'root', '');
                } catch (Exception $e) {
                    die("Ha ocurrido un error1. Avisa al soporte técnico");
                }
                $ok = true;
                $bd->beginTransaction();

                try {
                    $consulta = $bd->prepare("SELECT * FROM user WHERE username = :username");
                    $consulta->execute(['username' => $usuario]);
                } catch (Exception $e) {
                    die("Ha ocurrido un error2. Avisa al soporte técnico");
                }


                if ($user = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    if ($user['nombre'] == $nombre && $user['apellido1'] == $primerApellido && $user['apellido2'] == $segundoApellido && $user['username'] == $usuario) {
                        $filas_afectadas = $bd->exec("UPDATE user SET contrasenia = '$contrasenia' WHERE username = '$usuario'");

                        if ($filas_afectadas == 0) {
                            $ok = false;
                        }
                        if ($filas_afectadas == 1) {
                            $ok = true;
                        }
                    } else {
                        $ok = false;
                        echo json_encode(['error' => 'Datos incorrectos']);
                        exit;
                    }

                    if ($ok) {
                        $bd->commit();

                        $consulta = $bd->prepare("SELECT * FROM user WHERE username = :username");
                        $consulta->execute(['username' => $usuario]);

                        $usuarioCompleto = $consulta->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['usuario'] = $usuarioCompleto; // Establecer el nombre de usuario en la sesión
                        $_SESSION['tipo'] = "consumidor";
                        $usuarioFinal = array('usuario' => $_SESSION['usuario'], 'tipoUsuario' => $_SESSION['tipo']);
                        echo json_encode($usuarioFinal);
                    } else {
                        $bd->rollback();
                        exit;
                    }
                } else {
                    echo json_encode(['error' => 'Datos incorrectos']);
                    exit;
                }
            }
        }
    } else {
        header("Location:index.php");
        exit;
    }
}
