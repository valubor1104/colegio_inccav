<?php
// views/planillaLista.php
include_once(__DIR__ . '/../controladores/listarPlanilla.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Planillas</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Planillas</h2>

        <?php if (isset($_GET['msg'])): ?>
            <div class="pi-alert"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <div class="pi-actions-row">
            <a href="agregarPlanilla.php" class="btn-primary">Nueva planilla</a>
            <a href="../menu_principal.php" class="btn-secondary" style="margin-left:10px;">Volver al menú</a>
        </div>

        <table class="pi-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Monto</th>
                    <th>Método</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($planillas)): ?>
                    <tr><td colspan="7" class="pi-empty">No hay registros.</td></tr>
                <?php else: ?>
                    <?php foreach ($planillas as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['fecha']) ?></td>
                            <td><?= htmlspecialchars($p['descripcion']) ?></td>
                            <td><?= htmlspecialchars($p['monto']) ?></td>
                            <td>
                                <?php
                                    switch ($p['metodopago']) {
                                        case 1: echo 'Efectivo'; break;
                                        case 2: echo 'Tarjeta'; break;
                                        case 3: echo 'Transferencia'; break;
                                        default: echo 'Otro (' . htmlspecialchars($p['metodopago']) . ')'; break;
                                    }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($p['observaciones']) ?></td>
                            <td class="pi-td-actions">
                                <a class="btn-edit" href="editarPlanilla.php?id=<?= $p['id'] ?>">Editar</a>
                                <button class="btn-delete" onclick="confirmDelete(<?= $p['id'] ?>)">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar registro?',
            text: `Confirma que deseas eliminar el registro #${id}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../controladores/eliminarPlanilla.php?id=${id}`;
            }
        });
    }

    // Mostrar mensajes basado en querystring ?msg=...
    (function() {
        const params = new URLSearchParams(window.location.search);
        if (params.has('msg')) {
            const msg = params.get('msg');
            if (msg === 'created') {
                Swal.fire('Creado', 'Registro creado correctamente.', 'success');
            } else if (msg === 'updated') {
                Swal.fire('Actualizado', 'Registro actualizado correctamente.', 'success');
            } else if (msg === 'deleted') {
                Swal.fire('Eliminado', 'Registro eliminado correctamente.', 'success');
            } else if (msg === 'error') {
                Swal.fire('Error', 'Ocurrió un error. Intenta de nuevo.', 'error');
            }
            // Limpiar querystring para evitar duplicar mensajes al recargar
            history.replaceState(null, '', window.location.pathname);
        }
    })();
</script>
</html>
