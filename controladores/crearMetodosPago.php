<?php
// controladores/crearMetodosPago.php
// Script para crear la tabla `metodos_pago` y poblarla con valores iniciales.
include_once(__DIR__ . '/../config/conexion.php');

$sqlCreate = "CREATE TABLE IF NOT EXISTS metodos_pago (
    id TINYINT UNSIGNED NOT NULL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sqlCreate) === TRUE) {
    // Insertar valores si no existen
    $data = [
        [1, 'Efectivo'],
        [2, 'Tarjeta'],
        [3, 'Transferencia']
    ];
    $stmt = $conn->prepare("INSERT INTO metodos_pago (id, nombre) VALUES (?, ?) ON DUPLICATE KEY UPDATE nombre = VALUES(nombre)");
    foreach ($data as $row) {
        $stmt->bind_param('is', $row[0], $row[1]);
        $stmt->execute();
    }
    echo "Tabla metodos_pago creada y poblada.";
} else {
    echo "Error creando tabla: " . $conn->error;
}

?>
