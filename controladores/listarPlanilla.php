<?php
include_once(__DIR__ . '/../config/conexion.php');

// Traer planillas junto al nombre del método de pago si existe
$sql = "SELECT p.*, mp.nombre AS metodo_nombre 
        FROM planilla p
        LEFT JOIN metodos_pago mp ON mp.id = p.metodopago
        ORDER BY p.fecha DESC";
$result = $conn->query($sql);
$planillas = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $planillas[] = $row;
    }
}

?>
