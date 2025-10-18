<?php include_once(__DIR__ . '/../controladores/bancos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Cheque</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>.small{width:120px}</style>
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">CHEQUES</h2>
        <form id="chequeForm" method="post" action="../controladores/bancos.php">
            <input type="hidden" name="action" value="create_cheque">
            <input type="hidden" name="lines" id="linesInput">
            <label>Cuenta Bancaria</label>
            <select name="cuenta_id" required>
                <?php foreach ($cuentas as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['banco_nombre'] . ' - ' . $c['numero_cuenta']) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Fecha</label>
            <input type="date" name="fecha" value="<?= date('Y-m-d') ?>">
            <label>Nombre</label>
            <input type="text" name="nombre">
            <label>Numero</label>
            <input type="text" name="numero">
            <label>Valor</label>
            <input type="number" step="0.01" name="valor" id="valor">
            <label>Concepto</label>
            <input type="text" name="concepto">
            <div style="margin-top:8px"><button type="button" onclick="openLinesEditor()" class="btn-primary">Editar líneas contables</button>
            <button type="submit" class="btn-primary">Guardar cheque</button></div>
        </form>
        <div id="linesEditor" style="display:none; margin-top:12px">
            <h4>Líneas</h4>
            <table id="linesTable" class="pi-table"><thead><tr><th>Cuenta</th><th>Descripción</th><th>Debe</th><th>Haber</th><th></th></tr></thead><tbody></tbody></table>
            <button onclick="addLine()" class="btn-primary">Agregar línea</button>
            <div style="margin-top:8px">Total Debe: <span id="totalDebe">0.00</span> Total Haber: <span id="totalHaber">0.00</span></div>
            <button onclick="closeLinesEditor()" class="btn-secondary">Cerrar</button>
        </div>
    </div>
<script>
function openLinesEditor(){ document.getElementById('linesEditor').style.display='block'; }
function closeLinesEditor(){ document.getElementById('linesEditor').style.display='none'; }
function addLine(){
  const tbody = document.querySelector('#linesTable tbody');
  const tr = document.createElement('tr');
  tr.innerHTML = `<td><input name="cuenta[]"></td><td><input name="desc[]"></td><td><input class="num" name="debe[]" value="0"></td><td><input class="num" name="haber[]" value="0"></td><td><button onclick="this.closest(\'tr\').remove();calcTotals();return false;">X</button></td>`;
  tbody.appendChild(tr);
}
function calcTotals(){
  let debe=0, haber=0; document.querySelectorAll('.num').forEach(i=>{ const v=parseFloat(i.value)||0; if (i.name.includes('debe')) debe+=v; else haber+=v; });
  document.getElementById('totalDebe').innerText=debe.toFixed(2); document.getElementById('totalHaber').innerText=haber.toFixed(2);
}
document.getElementById('chequeForm').addEventListener('submit', function(e){
  e.preventDefault(); calcTotals();
  const debe = parseFloat(document.getElementById('totalDebe').innerText)||0; const haber = parseFloat(document.getElementById('totalHaber').innerText)||0;
  if (debe.toFixed(2) !== haber.toFixed(2)) { Swal.fire('Error','Totales Debe/Haber no coinciden','error'); return; }
  // serialize lines
  const rows = Array.from(document.querySelectorAll('#linesTable tbody tr'));
  const lines = rows.map(r=>({cuenta:r.querySelector('input[name^="cuenta"]').value, desc:r.querySelector('input[name^="desc"]').value, debe:parseFloat(r.querySelector('input[name^="debe"]').value)||0, haber:parseFloat(r.querySelector('input[name^="haber"]').value)||0}));
  document.getElementById('linesInput').value = JSON.stringify(lines);
  this.submit();
});
</script>
</body>
</html>
