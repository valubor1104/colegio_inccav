<?php
// controladores/cuentas.php
include_once(__DIR__ . '/../config/conexion.php');

// Listar cuentas (para incluir en vistas)
$cuentas = [];
$res = $conn->query("SELECT * FROM cuentas ORDER BY codigo ASC");
if ($res) {
    while ($r = $res->fetch_assoc()) $cuentas[] = $r;
}

// Crear cuenta (si POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $nivel = isset($_POST['nivel']) ? (int)$_POST['nivel'] : 1;
    $padre = isset($_POST['padre_id']) && $_POST['padre_id'] !== '' ? (int)$_POST['padre_id'] : null;

    $stmt = $conn->prepare("INSERT INTO cuentas (codigo, nombre, tipo, nivel, padre_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssii', $codigo, $nombre, $tipo, $nivel, $padre);
    if ($stmt->execute()) {
        header('Location: ../views/cuentasLista.php?msg=created'); exit;
    } else {
        header('Location: ../views/cuentasCrear.php?msg=error'); exit;
    }
}

// Actualizar cuenta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $nivel = isset($_POST['nivel']) ? (int)$_POST['nivel'] : 1;
    $padre = isset($_POST['padre_id']) && $_POST['padre_id'] !== '' ? (int)$_POST['padre_id'] : null;

    $stmt = $conn->prepare("UPDATE cuentas SET codigo = ?, nombre = ?, tipo = ?, nivel = ?, padre_id = ? WHERE id = ?");
    $stmt->bind_param('sssiii', $codigo, $nombre, $tipo, $nivel, $padre, $id);
    if ($stmt->execute()) {
        header('Location: ../views/cuentasLista.php?msg=updated'); exit;
    } else {
        header("Location: ../views/cuentasEditar.php?id={$id}&msg=error"); exit;
    }
}

// Eliminar cuenta (GET)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM cuentas WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: ../views/cuentasLista.php?msg=deleted'); exit;
}

?>
