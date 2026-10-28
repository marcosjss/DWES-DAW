<?php
    function cerrar (PDO $conexion) {
        $conexion = null;
        return $conexion;
    }

    //Cierre de sesion desde las páginas del juego
    function cerrarSesion() {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'cerrar_sesion') {
        cerrarSesion();
    }
?>
