<?php
    session_start();
    $colores = array("blue", "red", "green", "yellow", "orange", "pink", "purple", "gray");
    $coloresESP = array("Azul", "Rojo","Verde","Amarillo","Naranja","Rosa","Morado","Gris");
    $fase = $_SESSION['fase'] ?? 'configuracion';
    $nCirculos = $_SESSION['nCirculos'] ?? 4;
    $nColores = $_SESSION['nColores'] ?? 4;
    $colorFondo = $_COOKIE['cColor'] ?? 'white';

    function pintar_circulos(array $colores, int $nCirculos) {
        for ($k = 0; $k < $nCirculos; $k++) {
            $color = $colores[$k] ?? 'black';
            echo '<svg width="200" height="200">';
                echo '<circle cx="70" cy="70" r="70" fill="' . $color . '" />';
            echo '</svg>';
        }
    }

    function numero_colores(array $colores, int $nColores) {
        if ($nColores <= 0) {
            return array();
        }
        return array_slice($colores, 0, $nColores);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (($_POST['accion'] ?? '') === 'reiniciar') {
            $_SESSION = [];
            $fase = 'configuracion';
            $nCirculos = 4;
            $nColores = 4;
        } elseif (($_POST['accion'] ?? '') === 'iniciar') {
            $nCirculos = max(4, min(8, (int) ($_POST['nCirculos'] ?? 4)));
            $nColores = max(4, min(8, (int) ($_POST['nColores'] ?? 4)));
            $coloresDisponibles = numero_colores($colores, $nColores);
            $_SESSION['nCirculos'] = $nCirculos;
            $_SESSION['nColores'] = $nColores;
            $_SESSION['combinacion'] = [];
            $_SESSION['jugada'] = [];

            for ($k = 0; $k < $nCirculos; $k++) {
                $_SESSION['combinacion'][] = $coloresDisponibles[array_rand($coloresDisponibles)];
            }

            $_SESSION['fase'] = 'memorizacion';
            $fase = 'memorizacion';
        } elseif (($_POST['accion'] ?? '') === 'comenzar_juego' && $fase === 'memorizacion') {
            $_SESSION['fase'] = 'juego';
            $fase = 'juego';
        } elseif (isset($_POST['color_pulsado']) && $fase === 'juego') {
            $coloresDisponibles = numero_colores($colores, $nColores);
            $colorPulsado = $_POST['color_pulsado'];

            if (in_array($colorPulsado, $coloresDisponibles, true) && count($_SESSION['jugada'] ?? []) < $nCirculos) {
                $_SESSION['jugada'][] = $colorPulsado;
            }

            if (count($_SESSION['jugada'] ?? []) === $nCirculos) {
                $_SESSION['fase'] = 'resultado';
                $fase = 'resultado';
            }
        }

        if (($_POST['accion'] ?? '') === 'reiniciar') {
            session_destroy();
            unset($_SESSION['fase'], $_SESSION['nCirculos'], $_SESSION['nColores'], $_SESSION['combinacion'], $_SESSION['jugada']);
        }

        if (($_POST['accion'] ?? '') === 'fondo') {
            $colorFondo = $_POST['cColor'];
            crearCookie('cColor', $colorFondo);
        }
    }

    //COOKIES
    function crearCookie($nombreCookie,$valorCookie){
        setcookie($nombreCookie, $valorCookie, [
            'expires' => time() + 30 * 24 * 60 * 60,
            'path' => '/',
            'domain' => 'localhost',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax' 
        ]);
    }
?>