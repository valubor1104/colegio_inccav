<?php include_once(__DIR__ . '/../controladores/bancos.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Cuenta Bancaria</title>
    <link rel="stylesheet" href="../estilos/planilla.css">
</head>
<body class="pi-body">
    <div class="pi-card">
        <h2 class="pi-title">Nueva Cuenta Bancaria</h2>
        <form method="post" action="../controladores/bancos.php">
            <input type="hidden" name="action" value="create_account">
            <label>Banco</label>
            <?php $pre_bank = isset($_GET['bank_id']) ? (int)$_GET['bank_id'] : null; ?>
            <?php if ($pre_bank): ?>
                <?php foreach ($bancos as $bb) if ($bb['id']==$pre_bank) $bank_name = $bb['nombre']; ?>
                <input type="hidden" name="banco_id" value="<?= $pre_bank ?>">
                <div><strong><?= htmlspecialchars($bank_name ?? 'Banco seleccionado') ?></strong></div>
            <?php else: ?>
                <select name="banco_id" required>
                    <?php foreach ($bancos as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <label>Número</label>
            <input type="text" name="numero_cuenta" required>
            <label>Descripción</label>
            <input type="text" name="descripcion">
            <label>Moneda</label>
            <input type="text" name="moneda" value="GTQ">
            <label>Saldo inicial</label>
            <input type="number" step="0.01" name="saldo" value="0.00">
            <div style="margin-top:10px">
                <button class="btn-primary" type="submit">Crear</button>
                <a class="btn-secondary" href="cuentasBancariasLista.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
