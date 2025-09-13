<?php
   
   $servername = "82.197.82.175";
    $database = "u834187355_colegio";
    $username = "u834187355_valeria";
    $password = "X*3eUgd?MD$";

    $conn = new mysqli($servername, $username, $password, $database);
    if (!$conn) {
        echo 'Conexion fallida';
    }

    $conn->set_charset('utf8mb4');
?>