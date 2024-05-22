<?php
session_start();
header('Content-Type: application/json');
if (isset($_SESSION['usuario']) && isset($_SESSION['tipo'])) {
    echo json_encode(['usuario' => $_SESSION['usuario']]);
} else {
    echo json_encode(['error' => "Usuario no encontrado"]);
}
?>