<?php
function filtrar_acceso($adminRequerido = false) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit();
    }

    $rol = (int)$_SESSION['usuario']['Rol'];

    if($rol === 1 && !$adminRequerido) {
        header("Location: admin.php");
        exit();
    }

    if($rol !== 1 && $adminRequerido) {
        header("Location: inicio.php");
        exit();
    }
}
?>