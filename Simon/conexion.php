<?php
    $host="localhost";
    $usuario="root";
    $password="";
    $bd="agenda";
    //$puerto="8080";
    
    //$dsn="mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8mb4";
    $dsn="mysql:host=$host;dbname=$bd;charset=utf8mb4";
    
    try {
        $conexion = new PDO ($dsn, $usuario, $password);
    } catch (PDOException $e) {
        error_log("Error de conexion PDO: " . $e->getMessage());
    }
    return $conexion;
?>
