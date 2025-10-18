<?php include_once(__DIR__ . '/../controladores/bancos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cuentas Bancarias</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Cuentas Bancarias</h2>
        <div class="pi-actions-row">
            <a href="cuentasBancariasCrear.php" class="btn-primary">Nueva cuenta bancaria</a>
            <a href="../views/bancosLista.php" class="btn-secondary">Volver a Bancos</a>
        </div>
        <table class="pi-table">
            <thead><tr><th>ID</th><th>Banco</th><th>Número</th><th>Moneda</th><th>Saldo</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php if (empty($cuentas)): ?>
                <tr><td colspan="6" class="pi-empty">No hay cuentas bancarias.</td></tr>
            <?php else: ?>
                <?php foreach ($cuentas as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['id']) ?></td>
                        <td><?= htmlspecialchars($c['banco_nombre']) ?></td>
                        <td><?= htmlspecialchars($c['numero_cuenta']) ?></td>
                        <td><?= htmlspecialchars($c['moneda']) ?></td>
                        <td><?= htmlspecialchars(number_format($c['saldo'],2)) ?></td>
                        <td class="pi-td-actions">
                            <a class="btn-edit" href="movimientosLista.php?cuenta_id=<?= $c['id'] ?>">Movimientos</a>
                            <a class="btn-primary" href="chequesCrear.php?cuenta_id=<?= $c['id'] ?>" style="margin-left:6px; padding:6px 8px;">Cheques</a>
                            <button class="btn-delete" onclick="confirmDelete(<?= $c['id'] ?>, <?= $c['banco_id'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    function confirmDelete(id, bankId){
        Swal.fire({
            title: '¿Eliminar cuenta bancaria?',
            text: `Eliminar cuenta #${id}?`,
            icon: 'warning',
            showCancelButton: true
        }).then(r => { if (r.isConfirmed) window.location.href = `../controladores/bancos.php?action=delete_account&id=${id}&bank_id=${bankId}`; });
    }
</script>
</html>
