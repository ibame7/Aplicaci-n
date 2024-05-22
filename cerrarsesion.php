<?php
session_start();
if(isset($_SESSION['usuario'])&&isset($_SESSION['tipo'])){
    session_destroy();
    setcookie('PHPSESSID');
    header('Location: index.php');
    exit;
}
?>