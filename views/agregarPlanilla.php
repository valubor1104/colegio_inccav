<?php
// views/agregarPlanilla.php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agregar Planilla</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Agregar registro de planilla</h2>

        <div style="margin-bottom:10px;">
            <button type="button" class="btn-secondary" onclick="history.back()">Volver</button>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'error'): ?>
            <div class="pi-alert error">Ocurrió un error al guardar.</div>
        <?php endif; ?>

        <?php
            // Cargar métodos de pago desde la tabla
            include_once(__DIR__ . '/../config/conexion.php');
            $mpResult = $conn->query("SELECT id, nombre FROM metodos_pago ORDER BY id");
        ?>
        <form action="../controladores/insertarPlanilla.php" method="POST" class="pi-form">
            <label>Fecha</label>
            <input type="date" name="fecha" required>

            <label>Descripción</label>
            <input type="text" name="descripcion" maxlength="255" required>

            <label>Monto</label>
            <input type="number" step="0.01" name="monto" required>

            <label>Método de pago</label>
            <select name="metodopago" required>
                <?php if ($mpResult && $mpResult->num_rows > 0): ?>
                    <?php while ($m = $mpResult->fetch_assoc()): ?>
                        <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nombre']) ?></option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="1">Efectivo</option>
                    <option value="2">Tarjeta</option>
                    <option value="3">Transferencia</option>
                <?php endif; ?>
            </select>

            <label>Observaciones</label>
            <input type="text" name="observaciones" maxlength="255">

            <div class="pi-actions">
                <button type="submit" class="btn-primary">Guardar</button>
                <a href="planillaLista.php" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
<script>
    (function(){
        const params = new URLSearchParams(window.location.search);
        if (params.get('msg') === 'error'){
            Swal.fire('Error','Ocurrió un error al guardar.','error');
            history.replaceState(null,'', window.location.pathname);
        }
    })();
</script>
</body>
</html>
