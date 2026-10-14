<?php
    session_start();
    $combinacion = $_SESSION['combinacion'] ?? [];
    echo "<p>Combinación generada:</p>";
    foreach ($combinacion as $color) {
        echo "
            <svg width='200' height='200'>
                <circle cx='70' cy='70' r='70' fill='$color' />
            </svg>";
    };
    var_dump($_SESSION);

    //Pulso boton amarillo
    //Pinta 1er circulo de amarillo
    //Actualizo el array $_SESSION['jugada']
    //Actualizo el array $_SESSION['pulsaciones'] con pulsaciones++
?> 