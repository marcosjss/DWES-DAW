<?php
    session_start();
    $combinacion = $_SESSION['combinacion'] ?? [];
    echo "<p>Combinación generada:</p>";
    echo "<ul>";
    foreach ($combinacion as $color) {
        echo "
            <svg width='200' height='200'>
                <circle cx='70' cy='70' r='70' fill='$color' />
            </svg>";
    };
?>