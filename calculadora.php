<?php
    $x = $_POST['numero1'];
    $y = $_POST['numero2'];
    $tipo_operacion = $_POST['tipo_operacion'];
    $resultado ="";

    if ($tipo_operacion === "suma") {
        $resultado = $x + $y;
    } 
    else if ($tipo_operacion === "resta") {
        $resultado = $x - $y;
    }
    else if ($tipo_operacion === "multiplicacion") {
        $resultado = $x * $y;
    } else {
        if ($y == 0) {
            $resultado = "Error";
        } else {
        $resultado = $x / $y;
        }
    }
?>

<head>
    <title>Calculadora Marcos Suarez</title>
</head>
<body>
    <form action="" method="post">
        <input type="number" id="numero1" name="numero1" placeholder="Escribe un numero" required><br>
        <input type="number" id="numero2" name="numero2" placeholder="Escribe un numero" required><br>
        <select name="tipo_operacion" id="tipo_operacion">
            <option value="suma">+</option>
            <option value="resta">-</option>
            <option value="multiplicacion">*</option>
            <option value="division">/</option>
        </select><br>
        <button type="submit" class="btn-submit">Realizar operacion</button><br>
    </form>  
    <p>Resultado:<?php echo" $resultado"; ?><p>
</body>
