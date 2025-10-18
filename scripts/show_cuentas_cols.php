<?php
include_once __DIR__ . '/../config/conexion.php';
if (!isset($conn)) { echo "NO_CONN\n"; exit; }
$res = $conn->query("SHOW COLUMNS FROM cuentas_bancarias");
if (!$res) { echo "ERROR: " . $conn->error . "\n"; exit; }
while ($f = $res->fetch_assoc()) {
    echo $f['Field'] . "\n";
}

?>
