<?php
    $colores = array("blue", "red", "green", "yellow", "orange", "pink", "purple", "gray");
    $coloresESP = array("Azul", "Rojo", "Verde", "Amarillo", "Naranja", "Rosa", "Morado", "Gris");
    $colorFondo = $_COOKIE['cColor'] ?? 'white';

    $conexion = require 'conexion.php';
    $stmt = $conexion->query('SELECT * FROM configuracion WHERE id = 1');
    $configuracion = $stmt->fetch();
    $nCirculos = (int) ($_SESSION['nCirculos'] ?? $configuracion['nCirculos'] ?? 4);
    $nColores = (int) ($_SESSION['nColores'] ?? $configuracion['nColores'] ?? 4);

    function numero_colores(array $colores, int $nColores) {
        if ($nColores <= 0) {
            return array();
        }
        return array_slice($colores, 0, $nColores);
    }

    function pintar_circulos(array $colores, int $nCirculos) {
        $nCirculos = max(4, min(8, $nCirculos));

        for ($k = 0; $k < $nCirculos; $k++) {
            $color = htmlspecialchars($colores[$k] ?? 'black', ENT_QUOTES, 'UTF-8');
            echo '<svg width="200" height="200">';
            echo '<circle cx="70" cy="70" r="70" fill="' . $color . '" />';
            echo '</svg>';
        }
    }
?>