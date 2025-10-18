<?php
include_once(__DIR__ . '/../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos solo la fecha (YYYY-MM-DD) y añadimos la hora del servidor
    if (isset($_POST['fecha']) && $_POST['fecha'] !== '') {
        $fechaOnly = $_POST['fecha']; // formato YYYY-MM-DD
        $horaNow = date('H:i:s');
        $fecha = $fechaOnly . ' ' . $horaNow; // formato DATETIME
    } else {
        $fecha = null;
    }
    $descripcion = trim($_POST['descripcion'] ?? '');
    $monto = isset($_POST['monto']) ? (float)$_POST['monto'] : 0.00;
    $metodopago = isset($_POST['metodopago']) ? (int)$_POST['metodopago'] : 0;
    $observaciones = trim($_POST['observaciones'] ?? '');

    $stmt = $conn->prepare("INSERT INTO planilla (fecha, descripcion, monto, metodopago, observaciones) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        header("Location: ../views/agregarPlanilla.php?msg=error");
        exit;
    }
    $stmt->bind_param("ssdis", $fecha, $descripcion, $monto, $metodopago, $observaciones);

    if ($stmt->execute()) {
        header("Location: ../views/planillaLista.php?msg=created");
        exit;
    } else {
        header("Location: ../views/agregarPlanilla.php?msg=error");
        exit;
    }
}
?>
