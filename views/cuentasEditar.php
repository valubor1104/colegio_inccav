<?php
include_once(__DIR__ . '/../config/conexion.php');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$cuenta = null;
$cuentas = [];
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM cuentas WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $cuenta = $res->fetch_assoc();
}
$r = $conn->query("SELECT id, codigo, nombre FROM cuentas ORDER BY codigo");
if ($r) while ($row = $r->fetch_assoc()) $cuentas[] = $row;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Cuenta</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Editar cuenta</h2>
        <?php if (!$cuenta): ?>
            <div class="pi-alert error">Cuenta no encontrada.</div>
        <?php else: ?>
        <form action="../controladores/cuentas.php" method="POST" class="pi-form">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?= $cuenta['id'] ?>">
            <label>Código</label>
            <input type="text" name="codigo" value="<?= htmlspecialchars($cuenta['codigo']) ?>" required>
            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($cuenta['nombre']) ?>" required>
            <label>Tipo</label>
            <select name="tipo">
                <option value="activo" <?= $cuenta['tipo']=='activo' ? 'selected' : '' ?>>Activo</option>
                <option value="pasivo" <?= $cuenta['tipo']=='pasivo' ? 'selected' : '' ?>>Pasivo</option>
                <option value="patrimonio" <?= $cuenta['tipo']=='patrimonio' ? 'selected' : '' ?>>Patrimonio</option>
                <option value="ingreso" <?= $cuenta['tipo']=='ingreso' ? 'selected' : '' ?>>Ingreso</option>
                <option value="gasto" <?= $cuenta['tipo']=='gasto' ? 'selected' : '' ?>>Gasto</option>
            </select>
            <label>Nivel</label>
            <input type="number" name="nivel" value="<?= htmlspecialchars($cuenta['nivel']) ?>">
            <label>Padre (opcional)</label>
            <select name="padre_id">
                <option value="">-- Ninguno --</option>
                <?php foreach ($cuentas as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id']==$cuenta['padre_id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['codigo'].' - '.$c['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="pi-actions">
                <button class="btn-primary" type="submit">Actualizar</button>
                <a class="btn-secondary" href="cuentasLista.php">Cancelar</a>
                <button type="button" class="btn-delete" onclick="confirmDelete(<?= $cuenta['id'] ?>)">Eliminar</button>
            </div>
        </form>
        <?php endif; ?>
    </div>

<script>
    function confirmDelete(id){
        Swal.fire({
            title: '¿Eliminar cuenta?',
            text: 'Esto puede afectar asientos existentes.',
            icon: 'warning',
            showCancelButton: true
        }).then(r=>{ if (r.isConfirmed) window.location.href = `../controladores/cuentas.php?action=delete&id=${id}`; });
    }
</script>
</body>
</html>
