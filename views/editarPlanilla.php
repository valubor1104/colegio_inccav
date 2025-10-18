<?php
// views/editarPlanilla.php
include_once(__DIR__ . '/../config/conexion.php');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$plan = null;
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM planilla WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $plan = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Editar Planilla</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Editar planilla</h2>

        <div style="margin-bottom:10px;">
            <button type="button" class="btn-secondary" onclick="history.back()">Volver</button>
        </div>

        <?php if (!$plan): ?>
            <div class="pi-alert error">Registro no encontrado.</div>
            <a href="planillaLista.php" class="btn-secondary">Volver</a>
            <?php exit; ?>
        <?php endif; ?>

        <form action="../controladores/editarPlanilla.php" method="POST" class="pi-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($plan['id']) ?>">

            <label>Fecha</label>
            <?php $dt = substr($plan['fecha'], 0, 10); ?>
            <input type="date" name="fecha" value="<?= htmlspecialchars($dt) ?>" required>

            <label>Descripción</label>
            <input type="text" name="descripcion" maxlength="255" value="<?= htmlspecialchars($plan['descripcion']) ?>" required>

            <label>Monto</label>
            <input type="number" step="0.01" name="monto" value="<?= htmlspecialchars($plan['monto']) ?>" required>

            <label>Método de pago</label>
            <?php
                $mpRes = $conn->query("SELECT id, nombre FROM metodos_pago ORDER BY id");
            ?>
            <select name="metodopago" required>
                <?php if ($mpRes && $mpRes->num_rows > 0): ?>
                    <?php while ($m = $mpRes->fetch_assoc()): ?>
                        <option value="<?= $m['id'] ?>" <?= $plan['metodopago'] == $m['id'] ? 'selected' : '' ?>><?= htmlspecialchars($m['nombre']) ?></option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="1" <?= $plan['metodopago'] == 1 ? 'selected' : '' ?>>Efectivo</option>
                    <option value="2" <?= $plan['metodopago'] == 2 ? 'selected' : '' ?>>Tarjeta</option>
                    <option value="3" <?= $plan['metodopago'] == 3 ? 'selected' : '' ?>>Transferencia</option>
                <?php endif; ?>
            </select>

            <label>Observaciones</label>
            <input type="text" name="observaciones" maxlength="255" value="<?= htmlspecialchars($plan['observaciones']) ?>">

            <div class="pi-actions">
                <button type="submit" class="btn-primary">Actualizar</button>
                <a href="planillaLista.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<script>
    (function(){
        const params = new URLSearchParams(window.location.search);
        if (params.get('msg') === 'error'){
            Swal.fire('Error','Ocurrió un error al actualizar.','error');
            history.replaceState(null,'', window.location.pathname + window.location.search.replace(/([?&])msg=[^&]+/, ''));
        }
    })();
</script>
</body>
</html>
