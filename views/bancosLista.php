<?php include_once(__DIR__ . '/../controladores/bancos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bancos</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Bancos</h2>
        <div class="pi-actions-row">
            <a href="bancosCrear.php" class="btn-primary">Nuevo banco</a>
            <a href="../menu_principal.php" class="btn-secondary">Volver al menú</a>
        </div>
        <table class="pi-table">
            <thead><tr><th>ID</th><th>Nombre</th><th>Código</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php if (empty($bancos)): ?>
                <tr><td colspan="4" class="pi-empty">No hay bancos registrados.</td></tr>
            <?php else: ?>
                <?php foreach ($bancos as $b): ?>
                    <tr>
                        <td><?= htmlspecialchars($b['id']) ?></td>
                        <td><?= htmlspecialchars($b['nombre']) ?></td>
                        <td><?= htmlspecialchars($b['codigo']) ?></td>
                        <td class="pi-td-actions">
                            <a class="btn-edit" href="cuentasBancariasLista.php?bank_id=<?= $b['id'] ?>">Ver cuentas</a>
                            <a class="btn-primary" href="cuentasBancariasCrear.php?bank_id=<?= $b['id'] ?>" style="margin-left:6px; padding:6px 8px;">Nueva cuenta</a>
                            <button class="btn-delete" onclick="confirmDelete(<?= $b['id'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    function confirmDelete(id){
        Swal.fire({
            title: '¿Eliminar banco?',
            text: `Eliminar banco #${id}?`,
            icon: 'warning',
            showCancelButton: true
    }).then(r => { if (r.isConfirmed) window.location.href = `../controladores/bancos.php?action=delete_bank&id=${id}`; });
    }
    (function(){
        const params = new URLSearchParams(window.location.search);
        if (params.has('msg')){
            const m = params.get('msg');
            if (m === 'created') Swal.fire('Creado','Banco creado.','success');
            if (m === 'deleted') Swal.fire('Eliminado','Banco eliminado.','success');
            history.replaceState(null,'', window.location.pathname);
        }
    })();
</script>
</html>
