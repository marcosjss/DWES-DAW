<?php
function filtrar_acceso($es_admin_requerido = false) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit();
    }

    $rol = (int)$_SESSION['usuario']['Rol'];

    if($rol === 1 && !$es_admin_requerido) {
        header("Location: admin.php");
        exit();
    }

    if($rol !== 1 && $es_admin_requerido) {
        header("Location: simon.php");
        exit();
    }
}
?>