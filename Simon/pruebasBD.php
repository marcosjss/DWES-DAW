<?php include "logica.php";?>
<?php /*$conexion=*/include "conexion.php";?>

<?php consultaSelect($conexion);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas BD</title>
    <style>
        * { 
            text-align:center;
        }
        html {
            background-color: <?php if (isset($_COOKIE['cColor'])) { echo $_COOKIE['cColor'];} else {echo 'white';} ?>;
        }
        
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table {
            margin: auto;
        }
    </style>
</head>
<body>
    
</body>
</html>