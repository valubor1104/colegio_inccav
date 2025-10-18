<?php
// controladores/asientos.php
include_once(__DIR__ . '/../config/conexion.php');

// Listar asientos con totales
$asientos = [];
$res = $conn->query("SELECT a.*, 
    COALESCE(SUM(ai.debe),0) AS total_debe, 
    COALESCE(SUM(ai.haber),0) AS total_haber
    FROM asientos a
    LEFT JOIN asiento_items ai ON ai.asiento_id = a.id
    GROUP BY a.id
    ORDER BY a.fecha DESC");
if ($res) while ($r = $res->fetch_assoc()) {
    $r['total'] = max((float)$r['total_debe'], (float)$r['total_haber']);
    $asientos[] = $r;
}

// Obtener cuentas para selects
$cuentas = [];
$rc = $conn->query("SELECT id, codigo, nombre FROM cuentas ORDER BY codigo");
if ($rc) while ($r = $rc->fetch_assoc()) $cuentas[] = $r;

// Helper: parse items JSON from POST
function parse_items_from_post() {
    if (!isset($_POST['items'])) return [];
    $raw = $_POST['items'];
    if (is_array($raw)) return $raw;
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

// Crear asiento (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');
    $hora = date('H:i:s');
    $fechaTime = $fecha . ' ' . $hora;
    $descripcion = $_POST['descripcion'] ?? '';
    $items = parse_items_from_post();

    // calcular totales
    $totalDebe = 0; $totalHaber = 0;
    foreach ($items as $it) {
        $totalDebe += floatval($it['debe'] ?? 0);
        $totalHaber += floatval($it['haber'] ?? 0);
    }

    if (abs($totalDebe - $totalHaber) > 0.005) {
        header('Location: ../views/asientoCrear.php?msg=totals_mismatch'); exit;
    }

    $total = max($totalDebe, $totalHaber);
    $stmt = $conn->prepare("INSERT INTO asientos (fecha, descripcion, total) VALUES (?, ?, ?)");
    $stmt->bind_param('ssd', $fechaTime, $descripcion, $total);
    if ($stmt->execute()) {
        $asiento_id = $stmt->insert_id;
        $stmtItem = $conn->prepare("INSERT INTO asiento_items (asiento_id, cuenta_id, descripcion, debe, haber) VALUES (?, ?, ?, ?, ?)");
        foreach ($items as $it) {
            $cid = (int)$it['cuenta_id'];
            $desc = $it['descripcion'] ?? '';
            $debe = floatval($it['debe'] ?? 0);
            $haber = floatval($it['haber'] ?? 0);
            $stmtItem->bind_param('iisdd', $asiento_id, $cid, $desc, $debe, $haber);
            $stmtItem->execute();
        }
        header('Location: ../views/asientosLista.php?msg=created'); exit;
    } else {
        header('Location: ../views/asientoCrear.php?msg=error'); exit;
    }
}

// Actualizar asiento (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');
    $hora = date('H:i:s');
    $fechaTime = $fecha . ' ' . $hora;
    $descripcion = $_POST['descripcion'] ?? '';
    $items = parse_items_from_post();

    // calcular totales
    $totalDebe = 0; $totalHaber = 0;
    foreach ($items as $it) {
        $totalDebe += floatval($it['debe'] ?? 0);
        $totalHaber += floatval($it['haber'] ?? 0);
    }
    if (abs($totalDebe - $totalHaber) > 0.005) {
        header("Location: ../views/asientoEditar.php?id={$id}&msg=totals_mismatch"); exit;
    }

    $total = max($totalDebe, $totalHaber);
    $stmt = $conn->prepare("UPDATE asientos SET fecha = ?, descripcion = ?, total = ? WHERE id = ?");
    $stmt->bind_param('ssdi', $fechaTime, $descripcion, $total, $id);
    if ($stmt->execute()) {
        // eliminar items previos y agregar nuevos
        $conn->query("DELETE FROM asiento_items WHERE asiento_id = " . intval($id));
        $stmtItem = $conn->prepare("INSERT INTO asiento_items (asiento_id, cuenta_id, descripcion, debe, haber) VALUES (?, ?, ?, ?, ?)");
        foreach ($items as $it) {
            $cid = (int)$it['cuenta_id'];
            $desc = $it['descripcion'] ?? '';
            $debe = floatval($it['debe'] ?? 0);
            $haber = floatval($it['haber'] ?? 0);
            $stmtItem->bind_param('iisdd', $id, $cid, $desc, $debe, $haber);
            $stmtItem->execute();
        }
        header('Location: ../views/asientosLista.php?msg=updated'); exit;
    } else {
        header("Location: ../views/asientoEditar.php?id={$id}&msg=error"); exit;
    }
}

// Eliminar asiento (GET)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM asientos WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: ../views/asientosLista.php?msg=deleted'); exit;
}

?>
