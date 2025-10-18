<?php
include_once(__DIR__ . '/../config/conexion.php');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM planilla WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
header("Location: ../views/planillaLista.php?msg=deleted");
exit;
?>
