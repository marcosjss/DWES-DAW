<?php
$r = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['a'], $_POST['b'], $_POST['c'])) {
    $a = (float) $_POST['a'];
    $b = (float) $_POST['b'];
    $c = (float) $_POST['c'];

    if ($a != 0) {
        $resultado = ecuacion($a, $b, $c);
    } else {
        $resultado = false;
    }

    if ($resultado === false) {
        $r = "La ecuación no tiene soluciones reales";
    } else {
        $r = "Valores ingresados: a = $a, b = $b, c = $c <br>";
        $r .= 'Resultado: x1 = ' . $resultado[0] . ', x2 = ' . $resultado[1];
    }
}

function ecuacion($a, $b, $c) {
    $raiz = ($b * $b) - (4 * $a * $c);
    if ($raiz < 0) {
        return false;
    }

    $x1 = (-$b + sqrt($raiz)) / (2 * $a);
    $x2 = (-$b - sqrt($raiz)) / (2 * $a);

    return [$x1, $x2];
}

function palindrono($cadena) {
    $cadena= strtolower(str_replace(' ', '', trim($cadena)));
    if ($cadena == strrev($cadena)) {
        return true;
    } else {
        return false;
    }
}

$arrayPredeterminado = array(10, 45, 2, 8, 33, 15, 7, 12, 50, 4);

function limite($arrayNumeros, $limite) {
    $cantidad = $limite;

    if ($cantidad <= 0) {
        return array();
    }

    return array_slice($arrayNumeros, 0, $cantidad);
}

function ejecutarPruebas() {
    echo "<h2>Resultados de las pruebas (3 funciones por bloque)</h2>";
    echo "<h3>1. Funciones de Variables</h3>";
    $var1 = 42;
    $var2 = "";

    echo "<p><strong>1. isset(\$var1):</strong> " . (isset($var1) ? 'TRUE' : 'FALSE') . "</p>";
    echo "<p><strong>2. empty(\$var2):</strong> " . (empty($var2) ? 'TRUE' : 'FALSE') . "</p>";
    echo "<p><strong>3. is_int(\$var1):</strong> " . (is_int($var1) ? 'TRUE' : 'FALSE') . "</p>";

    echo "<h3>2. Funciones de Cadenas</h3>";
    $texto = "servidor php web";

    echo "<p>Texto original: <em>'$texto'</em></p>";
    echo "<p><strong>1. strlen(\$texto):</strong> " . strlen($texto) . " caracteres</p>";
    echo "<p><strong>2. strtoupper(\$texto):</strong> " . strtoupper($texto) . "</p>";

    $palabras = explode(" ", $texto);
    echo "<p><strong>3. explode(' ', \$texto):</strong></p>";
    echo "<pre>";
    print_r($palabras);
    echo "</pre>";

    echo "<h3>3. Funciones de Array</h3>";
    $animales = array("z" => "Zorro", "a" => "Abeja", "p" => "Perro");

    echo "<p><strong>1. count(\$animales):</strong> " . count($animales) . " elementos</p>";

    $claves = array_keys($animales);
    echo "<p><strong>2. array_keys(\$animales):</strong></p>";
    echo "<pre>";
    print_r($claves);
    echo "</pre>";

    ksort($animales);
    echo "<p><strong>3. ksort(\$animales):</strong></p>";
    echo "<pre>";
    print_r($animales);
    echo "</pre>";
}
?>
