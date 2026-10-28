<?php
    //Cambiar en clase el 3307 por 3306
    $host="localhost";
    $port = "3306";
    $usuario="root";
    $password="";
    $bd="agenda";
    
    $dsn="mysql:host=$host;port=$port;dbname=$bd;charset=utf8mb4";
    
    try {
        $conexion = new PDO ($dsn, $usuario, $password);
    } catch (PDOException $e) {
        error_log("Error de conexion PDO: " . $e->getMessage());
        throw $e;
    }
    return $conexion;
?>
