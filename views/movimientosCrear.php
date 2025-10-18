<?php include_once(__DIR__ . '/../controladores/bancos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Movimiento</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Nuevo Movimiento</h2>
        <form method="post" action="../controladores/bancos.php">
            <input type="hidden" name="action" value="create_mov">
            <input type="hidden" name="cuenta_id" value="<?= isset($_GET['cuenta_id'])? (int)$_GET['cuenta_id'] : '' ?>">
            <label>Fecha</label>
            <input type="datetime-local" name="fecha" required>
            <label>Tipo</label>
            <select name="tipo">
                <option value="ingreso">Ingreso</option>
                <option value="egreso">Egreso</option>
            </select>
            <label>Monto</label>
            <input type="number" step="0.01" name="monto" required>
            <label>Descripción</label>
            <input type="text" name="descripcion">
            <label>Referencia</label>
            <input type="text" name="referencia">
            <div style="margin-top:10px">
                <button class="btn-primary" type="submit">Registrar</button>
                <a class="btn-secondary" href="movimientosLista.php?cuenta_id=<?= isset($_GET['cuenta_id'])? (int)$_GET['cuenta_id'] : '' ?>">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
