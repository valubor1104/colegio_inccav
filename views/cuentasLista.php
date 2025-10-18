<?php
include_once(__DIR__ . '/../controladores/cuentas.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Catálogo de Cuentas</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Catálogo de Cuentas</h2>
        <div class="pi-actions-row">
            <a href="cuentasCrear.php" class="btn-primary">Nueva cuenta</a>
            <a href="../menu_principal.php" class="btn-secondary">Volver al menú</a>
        </div>
        <table class="pi-table">
            <thead><tr><th>Código</th><th>Nombre</th><th>Tipo</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php foreach ($cuentas as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['codigo']) ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td><?= htmlspecialchars($c['tipo']) ?></td>
                    <td class="pi-td-actions">
                        <a class="btn-edit" href="cuentasEditar.php?id=<?= $c['id'] ?>">Editar</a>
                        <button class="btn-delete" onclick="confirmDelete(<?= $c['id'] ?>)">Eliminar</button>
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
    function confirmDelete(id){
        Swal.fire({
            title: '¿Eliminar cuenta?',
            text: `Eliminar la cuenta #${id}?`,
            icon: 'warning',
            showCancelButton: true
        }).then(r=>{ if (r.isConfirmed) window.location.href = `../controladores/cuentas.php?action=delete&id=${id}`; });
    }

    (function(){
        const params = new URLSearchParams(window.location.search);
        if (params.has('msg')){
            const m = params.get('msg');
            if (m === 'created') Swal.fire('Creado','Cuenta creada.','success');
            if (m === 'updated') Swal.fire('Actualizado','Cuenta actualizada.','success');
            if (m === 'deleted') Swal.fire('Eliminado','Cuenta eliminada.','success');
            if (m === 'error') Swal.fire('Error','Ocurrió un error.','error');
            history.replaceState(null,'', window.location.pathname);
        }
    })();
</script>
