<?php
    $host="localhost";
    $port = "3306";
    $usuario="root";
    $password="";
    $bd="agenda";
    
    $dsn="mysql:host=$host;port=$port;dbname=$bd;charset=utf8mb4";
    
    try {
        $conexion = new PDO ($dsn, $usuario, $password);
    } catch (PDOException $e) {
        throw $e;
    }
    return $conexion;
?>
