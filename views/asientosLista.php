<?php include_once(__DIR__ . '/../controladores/asientos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Libro Diario / Asientos</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Asientos</h2>
        <div class="pi-actions-row">
            <a href="asientoCrear.php" class="btn-primary">Nuevo asiento</a>
            <a href="../menu_principal.php" class="btn-secondary">Volver al menú</a>
        </div>
        <table class="pi-table">
            <thead><tr><th>ID</th><th>Fecha</th><th>Descripción</th><th>Referencia</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach ($asientos as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['id']) ?></td>
                    <td><?= htmlspecialchars($a['fecha']) ?></td>
                    <td><?= htmlspecialchars($a['descripcion']) ?></td>
                    <td><?= htmlspecialchars($a['referencia']) ?></td>
                    <td class="pi-td-actions">
                        <a class="btn-edit" href="asientoEditar.php?id=<?= $a['id'] ?>">Editar</a>
                        <button class="btn-delete" onclick="confirmDelete(<?= $a['id'] ?>)">Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar asiento?',
            text: `Confirma que deseas eliminar el asiento #${id}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../controladores/asientos.php?action=delete&id=${id}`;
            }
        });
    }

    (function() {
        const params = new URLSearchParams(window.location.search);
        if (params.has('msg')) {
            const msg = params.get('msg');
            if (msg === 'created') Swal.fire('Creado','Asiento creado.','success');
            if (msg === 'updated') Swal.fire('Actualizado','Asiento actualizado.','success');
            if (msg === 'deleted') Swal.fire('Eliminado','Asiento eliminado.','success');
            if (msg === 'totals_mismatch') Swal.fire('Error','Totales no coinciden.','error');
            history.replaceState(null, '', window.location.pathname);
        }
    })();
</script>
