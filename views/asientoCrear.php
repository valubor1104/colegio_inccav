<?php include_once(__DIR__ . '/../controladores/asientos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Asiento</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Crear Asiento</h2>
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'totals_mismatch'): ?>
            <div class="pi-alert error">Los totales de debe y haber no coinciden.</div>
        <?php endif; ?>
        <form id="asientoForm" action="../controladores/asientos.php" method="POST">
            <input type="hidden" name="action" value="create">
            <label>Fecha</label>
            <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>
            <label>Descripción</label>
            <input type="text" name="descripcion">

            <h4>Detalles</h4>
            <table id="itemsTable" class="pi-table">
                <thead><tr><th>Cuenta</th><th>Descripción</th><th>Debe</th><th>Haber</th><th></th></tr></thead>
                <tbody></tbody>
            </table>
            <button type="button" class="btn-secondary" onclick="addRow()">Agregar línea</button>
            <div style="margin-top:10px;">
                <strong>Total Debe:</strong> <span id="totalDebe">0.00</span>
                &nbsp;&nbsp; <strong>Total Haber:</strong> <span id="totalHaber">0.00</span>
            </div>

            <div class="pi-actions">
                <button class="btn-primary" type="submit">Guardar asiento</button>
                <a class="btn-secondary" href="asientosLista.php">Cancelar</a>
            </div>
            <input type="hidden" name="items" id="itemsInput">
        </form>
    </div>

<script>
    const cuentas = <?= json_encode($cuentas) ?>;
    function addRow(){
        const tbody = document.querySelector('#itemsTable tbody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="cuenta_id">${cuentas.map(c=>`<option value="${c.id}">${c.codigo} - ${c.nombre}</option>`).join('')}</select>
            </td>
            <td><input type="text" name="desc"></td>
            <td><input type="number" step="0.01" name="debe" value="0"></td>
            <td><input type="number" step="0.01" name="haber" value="0"></td>
            <td><button type="button" onclick="this.closest('tr').remove()">Eliminar</button></td>
        `;
        tbody.appendChild(tr);
    }

    // serializar items antes de enviar
    document.getElementById('asientoForm').addEventListener('submit', function(e){
        const rows = Array.from(document.querySelectorAll('#itemsTable tbody tr'));
        const items = rows.map(r=>{
            return {
                cuenta_id: r.querySelector('select[name="cuenta_id"]').value,
                descripcion: r.querySelector('input[name="desc"]').value,
                debe: r.querySelector('input[name="debe"]').value,
                haber: r.querySelector('input[name="haber"]').value
            };
        });
        document.getElementById('itemsInput').value = JSON.stringify(items);
    });

    function recalcTotals(){
        const rows = Array.from(document.querySelectorAll('#itemsTable tbody tr'));
        let td=0, th=0;
        rows.forEach(r=>{
            const d = parseFloat(r.querySelector('input[name="debe"]').value) || 0;
            const h = parseFloat(r.querySelector('input[name="haber"]').value) || 0;
            td += d; th += h;
        });
        document.getElementById('totalDebe').innerText = td.toFixed(2);
        document.getElementById('totalHaber').innerText = th.toFixed(2);
    }

    // Delegación: recalcular cuando cambian inputs
    document.addEventListener('input', function(e){
        if (e.target && (e.target.name === 'debe' || e.target.name === 'haber')) recalcTotals();
    });

    // Inicializar totales
    recalcTotals();
</script>
</body>
</html>
