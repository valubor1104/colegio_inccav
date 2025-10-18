<?php include_once(__DIR__ . '/../controladores/bancos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Movimientos Bancarios</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Movimientos - Cuenta <?= isset($cuenta_id)?$cuenta_id:'' ?></h2>
        <div class="pi-actions-row">
            <a href="movimientosCrear.php?cuenta_id=<?= isset($cuenta_id)?$cuenta_id:'' ?>" class="btn-primary">Nuevo movimiento</a>
            <a href="cuentasBancariasLista.php" class="btn-secondary">Volver</a>
        </div>
        <table class="pi-table">
            <thead><tr><th>ID</th><th>Fecha</th><th>Tipo</th><th>Monto</th><th>Descripción</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php if (empty($movimientos)): ?>
                <tr><td colspan="6" class="pi-empty">No hay movimientos.</td></tr>
            <?php else: ?>
                <?php foreach ($movimientos as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['id']) ?></td>
                        <td><?= htmlspecialchars($m['fecha']) ?></td>
                        <td><?= htmlspecialchars($m['tipo']) ?></td>
                        <td><?= htmlspecialchars(number_format($m['monto'],2)) ?></td>
                        <td><?= htmlspecialchars($m['descripcion']) ?></td>
                        <td class="pi-td-actions">
                            <button class="btn-delete" onclick="confirmDelete(<?= $m['id'] ?>, <?= $m['cuenta_bancaria_id'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    function confirmDelete(id, cuentaId){
        Swal.fire({
            title: '¿Eliminar movimiento?',
            text: `Eliminar movimiento #${id}?`,
            icon: 'warning',
            showCancelButton: true
        }).then(r => { if (r.isConfirmed) window.location.href = `../controladores/bancos.php?action=delete_mov&id=${id}&cuenta_id=${cuentaId}`; });
    }
</script>
</html>
