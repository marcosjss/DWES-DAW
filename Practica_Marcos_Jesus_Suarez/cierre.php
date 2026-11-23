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

    $accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

    if ($accion === 'cerrar_sesion') {
        cerrarSesion();
    }
?>
