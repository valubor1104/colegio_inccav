<?php include_once(__DIR__ . '/../controladores/cuentas.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Crear cuenta contable</h2>
        <form action="../controladores/cuentas.php" method="POST" class="pi-form">
            <input type="hidden" name="action" value="create">
            <label>Código</label>
            <input type="text" name="codigo" required>
            <label>Nombre</label>
            <input type="text" name="nombre" required>
            <label>Tipo</label>
            <select name="tipo">
                <option value="activo">Activo</option>
                <option value="pasivo">Pasivo</option>
                <option value="patrimonio">Patrimonio</option>
                <option value="ingreso">Ingreso</option>
                <option value="gasto">Gasto</option>
            </select>
            <label>Nivel</label>
            <input type="number" name="nivel" value="1">
            <label>Padre (opcional)</label>
            <select name="padre_id">
                <option value="">-- Ninguno --</option>
                <?php foreach ($cuentas as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['codigo'].' - '.$c['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="pi-actions">
                <button class="btn-primary" type="submit">Crear</button>
                <a class="btn-secondary" href="cuentasLista.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
